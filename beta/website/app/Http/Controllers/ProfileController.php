<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function me()
    {
        $meResponse = $this->api->authGet('members/me');
        $meData = $meResponse['data'] ?? [];
        $d = $meData['profile'] ?? [];
        $phone = $d['user']['phone'] ?? null;

        $boxResponse = $this->api->authGet('members/me');
        $horoscope_boxes = $boxResponse['data']['profile']['horoscope_boxes'] ?? [];
        $member = [
            'id'         => $meData['id'] ?? null,
            'profile_id' => $meData['profile_id'] ?? null,
            'member_no'  => $meData['member_no'] ?? null,
            'restricted' => false,
            'is_own'     => true,
            'basic' => [
                'name'            => $d['user']['name'] ?? null,
                'age'             => $d['age'] ?? null,
                'dob'             => $d['dob'] ?? null,
                'gender'          => $d['gender'] ?? null,
                'marital_status'  => $d['marital_status'] ?? null,
                'religion'        => $d['religion'] ?? null,
                'caste'           => $d['caste'] ?? null,
                'subcaste'        => $d['subcaste'] ?? null,
                'city'            => $d['city'] ?? null,
                'state'           => $d['state'] ?? null,
                'country'         => $d['country'] ?? null,
                'education'       => $d['education'] ?? null,
                'occupation'      => $d['occupation'] ?? null,
                'income'          => $d['income'] ?? null,
                'bio'             => $d['bio'] ?? null,
                'height'          => $d['height'] ?? null,
                'weight'          => $d['weight'] ?? null,
                'profile_photo'   => (str_starts_with($d['profile_photo'] ?? '', 'http') ? $d['profile_photo'] : 'https://api.thirumanam.info/' . ($d['profile_photo'] ?? '')),
                
                'membership_type' => $d['membership_type'] ?? null,
                'physical_status' => $d['physical_status'] ?? null,
                'mother_tongue'   => $d['mother_tongue'] ?? null,
                'introduction'    => $d['introduction'] ?? $d['bio'] ?? null,
            ],
            'horoscope' => [
                'dob'                => $d['dob'] ?? null,
                'birth_time'         => $d['birth_time'] ?? null,
                'birth_city'         => $d['birth_city'] ?? $d['birth_place'] ?? null,
                'birth_place'        => $d['birth_place'] ?? null,
                'star'               => $d['star'] ?? null,
                'rasi'               => $d['rasi'] ?? null,
                'nakshatra'          => $d['nakshatra'] ?? null,
                'dosham'             => $d['dosham'] ?? null,
                'paksha'             => $d['paksha'] ?? null,
                'tithi'              => $d['tithi'] ?? null,
                'ganam'              => $d['ganam'] ?? null,
                'nadi'               => $d['nadi'] ?? null,
                'lakknam'            => $d['lakknam'] ?? null,
                'padam'              => $d['padam'] ?? null,
                'horoscope_matching' => $d['horoscope_matching'] ?? null,
                'directional_balance'=> $d['directional_balance'] ?? null,
            ],
            'physical' => [
                'height'          => $d['height'] ?? null,
                'weight'          => $d['weight'] ?? null,
                'complexion'      => $d['complexion'] ?? null,
                'body_type'       => $d['body_type'] ?? null,
                'blood_group'     => $d['blood_group'] ?? null,
                'physical_status' => $d['physical_status'] ?? null,
                'eye_color'       => $d['eye_color'] ?? null,
                'hair_color'      => $d['hair_color'] ?? null,
            ],
            'career' => [
                'education'      => $d['education'] ?? null,
                'occupation'     => $d['occupation'] ?? null,
                'income'         => $d['income'] ?? null,
                'work_location'  => $d['work_location'] ?? null,
                'career_profile' => $d['career_profile'] ?? null,
                'study_details'  => $d['study_details'] ?? null,
                'earnings'       => $d['earnings'] ?? null,
                'income_amount'  => $d['income_amount'] ?? null,
            ],
            'contact' => [
                'mobile'           => $d['mobile'] ?? $phone ?? null,
                'alternate_number' => $d['alternate_number'] ?? null,
                'landline'         => $d['landline'] ?? null,
                'address'          => $d['address'] ?? null,
                'current_city'     => $d['current_city'] ?? $d['city'] ?? null,
                'city'             => $d['city'] ?? null,
                'state'            => $d['state'] ?? null,
                'country'          => $d['country'] ?? null,
                'postal_code'      => $d['postal_code'] ?? null,
                'native_place'     => $d['native_place'] ?? null,
            ],
            'partner' => [
                'preferred_age'  => $d['partner_preference']['preferred_age'] ?? null,
                'education'      => $d['partner_preference']['education'] ?? null,
                'caste'          => $d['partner_preference']['caste'] ?? null,
                'marital_status' => $d['partner_preference']['marital_status'] ?? null,
                'dosham'         => $d['partner_preference']['dosham'] ?? null,
                'about_partner'  => $d['partner_preference']['about_partner'] ?? null,
            ],
            'family'             => $d['family_detail'] ?? $d['family'] ?? null,
            'partner_preference' => $d['partner_preference'] ?? null,
            'horoscope_boxes'    => $horoscope_boxes,
            'photos'             => $d['photos'] ?? [],
        ];

        return view('members.show', compact('member'));
    }

    public function edit()
    {
        $me = $this->api->authGet('/members/me');
        $user    = $me['data'] ?? Session::get('user');
        $profile = $user['profile'] ?? [];

        if (!empty($user)) {
            Session::put('user', $user);
        }

        $boxResponse = $this->api->authGet('members/me');
        $horoscope_boxes = $boxResponse['data']['profile']['horoscope_boxes'] ?? [];

        return view('profile.edit', compact('user', 'profile', 'horoscope_boxes'));
    }

    public function update(Request $request)
    {
        $me        = $this->api->authGet('/members/me');
        $user      = $me['data'] ?? Session::get('user');
        $profileId = $user['profile']['id'] ?? null;

        if (!$profileId) {
            return response()->json(['success' => false, 'message' => 'Profile not found.'], 422);
        }

        $response = $this->api->authPost("/profile/{$profileId}", $request->all());

        if ($response['success'] ?? false) {
            Session::put('user', $user);
            return response()->json(['success' => true, 'message' => 'Profile updated successfully!']);
        }

        return response()->json([
            'success' => false,
            'message' => $response['message'] ?? 'Failed to update profile.',
        ], 422);
    }



    public function saveHoroscopeBatch(Request $request)
    {
        $profileId = $request->input('profile_id');
        $allItems  = $request->input('items', []);

        if (!$profileId || empty($allItems)) {
            return response()->json(['success' => false, 'message' => 'Missing required fields.'], 422);
        }

        $response = $this->api->authPost('horoscope', [
            'is_first' => true,
            'items'    => array_map(function($item) use ($profileId) {
                return [
                    'profile_id'  => (int)$profileId,
                    'box_number'  => (int)($item['box_number'] ?? 0),
                    'item_number' => (int)($item['item_number'] ?? 1),
                    'type'        => $item['type'] ?? 'ZODIAC',
                    'value'       => $item['value'] ?? '',
                ];
            }, $allItems),
        ]);

        return response()->json($response);
    }

    public function changePassword(Request $request)
    {
        $current  = $request->input('current_password');
        $new      = $request->input('new_password');
        $confirm  = $request->input('new_password_confirmation');

        if (empty($current) || empty($new) || empty($confirm)) {
            return response()->json(['success' => false, 'message' => 'All fields are required.'], 422);
        }
        if ($new !== $confirm) {
            return response()->json(['success' => false, 'message' => 'New passwords do not match.'], 422);
        }
        if (strlen($new) < 6) {
            return response()->json(['success' => false, 'message' => 'Password must be at least 6 characters.'], 422);
        }

        $response = $this->api->authPost('members/change-password', [
            'current_password' => $current,
            'new_password'     => $new,
            'confirm_password' => $confirm,
        ]);

        if ($response['success'] ?? false) {
            return response()->json(['success' => true, 'message' => 'Password changed successfully!']);
        }

        return response()->json([
            'success' => false,
            'message' => $response['message'] ?? 'Failed to change password.',
        ], 422);
    }
    
    public function deactivate(Request $request)
{
    $response = $this->api->authPost('members/deactivate-self', []);

    if ($response['success'] ?? false) {
        Session::flush();
        return response()->json(['success' => true, 'message' => 'Your profile has been deactivated.']);
    }

    return response()->json([
        'success' => false,
        'message' => $response['message'] ?? 'Failed to deactivate profile.',
    ], 422);
}

    public function uploadPhoto(Request $request)
    {
        if (!$request->hasFile('photo_url')) {
            return response()->json(['success' => false, 'message' => 'No file provided.'], 422);
        }

        $profileId = $request->input('profile_id');
        $files = $request->file('photo_url');
        $file = is_array($files) ? $files[0] : $files;

        $response = $this->api->uploadProfilePhoto($profileId, $file);

        return response()->json($response);
    }
}
