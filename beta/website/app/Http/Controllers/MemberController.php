<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;

class MemberController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index(Request $request)
    {
        $response = $this->api->authGet('members/filter-by-savaran');

        $profiles = $response['data']['profiles'] ?? [];

        // Apply basic filters client-side from what API returns
        $search        = $request->get('search');
        $ageFrom       = $request->get('age_from');
        $ageTo         = $request->get('age_to');
        $maritalStatus = $request->get('marital_status');
        $education     = $request->get('education');
        $city          = $request->get('city');
        $star          = $request->get('star');
        $rasi          = $request->get('rasi');

        if ($search) {
            $profiles = array_filter($profiles, fn($p) =>
                str_contains(strtolower($p['name'] ?? ''), strtolower($search))
            );
        }
        if ($ageFrom) {
            $profiles = array_filter($profiles, fn($p) => ($p['age'] ?? 0) >= (int)$ageFrom);
        }
        if ($ageTo) {
            $profiles = array_filter($profiles, fn($p) => ($p['age'] ?? 0) <= (int)$ageTo);
        }
        if ($maritalStatus) {
            $profiles = array_filter($profiles, fn($p) =>
                strtolower($p['profile_marital_status'] ?? '') === strtolower($maritalStatus)
            );
        }
        if ($education) {
            $profiles = array_filter($profiles, fn($p) =>
                str_contains(strtolower($p['study_details'] ?? ''), strtolower($education))
            );
        }
        if ($city) {
            $profiles = array_filter($profiles, fn($p) =>
                str_contains(strtolower($p['city'] ?? ''), strtolower($city))
            );
        }
        if ($star) {
            $profiles = array_filter($profiles, fn($p) =>
                strtolower($p['star'] ?? '') === strtolower($star)
            );
        }
        if ($rasi) {
            $profiles = array_filter($profiles, fn($p) =>
                strtolower($p['rasi'] ?? '') === strtolower($rasi)
            );
        }

        $profiles    = array_values($profiles);
        $total       = count($profiles);

        // Manual pagination (12 per page)
        $perPage     = 12;
        $currentPage = (int) $request->get('page', 1);
        $offset      = ($currentPage - 1) * $perPage;
        $members     = array_slice($profiles, $offset, $perPage);
        $lastPage    = max(1, (int) ceil($total / $perPage));

        // Prepend base URL to profile photos
       // Normalise field names from filter-by-savaran response
        $members = array_map(function ($m) {
            $photo = $m['profile_photo'] ?? '';
            if ($photo && !str_starts_with($photo, 'http')) {
                $m['profile_photo'] = 'https://api.thirumanam.info/' . $photo;
            }
            $m['gender']         = $m['profile_gender'] ?? $m['gender'] ?? null;
            $m['marital_status'] = $m['profile_marital_status'] ?? $m['marital_status'] ?? null;
            $m['education']      = $m['study_details'] ?? null;
            $m['city']           = null; // not returned by filter-by-savaran
            return $m;
        }, $members);

        return view('members.index', compact('members', 'total', 'lastPage', 'currentPage'));
    }

    public function show(Request $request, $id)
    {
        // $id here is profile_id (from listing cards)
        $response = $this->api->authGet("members/filtered-member-details/{$id}");

        if (!($response['success'] ?? false)) {
            abort(404);
        }

        $d = $response['data'];

        $meResponse   = $this->api->authGet('members/me');
        $meData       = $meResponse['data'] ?? [];
        $myProfileId  = $meData['profile_id'] ?? null;
        $myMembership = $meData['membership']['slug'] ?? 'default';

        $restricted = ($myMembership === 'default');
        $isOwn      = ((int)$myProfileId === (int)$id);

        $basic = $d['basic'] ?? [];
        $photo = $basic['profile_photo'] ?? '';
        if ($photo && !str_starts_with($photo, 'http')) {
            $photo = 'https://api.thirumanam.info/' . $photo;
        }

        $member = [
            'id'         => $d['member_id'] ?? null,
            'profile_id' => $id,
            'member_no'  => $d['member_no'] ?? null,
            'restricted' => $restricted,
            'is_own'     => $isOwn,
            'interactions' => $d['interactions'] ?? [],

            'basic' => [
                'name'            => $basic['name'] ?? null,
                'age'             => $basic['age'] ?? null,
                'dob'             => $basic['dob'] ?? null,
                'gender'          => $basic['gender'] ?? null,
                'marital_status'  => $basic['marital_status'] ?? null,
                'physical_status' => $basic['physical_status'] ?? null,
                'profile_photo'   => $photo,
                'religion'        => $d['astronomic']['religion'] ?? null,
                'caste'           => $d['family']['caste'] ?? null,
                'mother_tongue'   => $d['location']['mother_tongue'] ?? null,
                'introduction'    => $d['basic']['introduction'] ?? null,
                'bio'             => $d['basic']['bio'] ?? null,
                'city'            => $d['location']['city'] ?? null,
                'state'           => $d['location']['state'] ?? null,
                'country'         => $d['location']['country'] ?? null,
                'education'       => $d['education']['education'] ?? null,
                'occupation'      => $d['career']['occupation'] ?? null,
                'income'          => $d['career']['income'] ?? null,
                'height'          => $d['physical']['height'] ?? null,
                'weight'          => $d['physical']['weight'] ?? null,
                'membership_type' => $d['membership_name'] ?? null,
            ],

            'horoscope' => [
                'dob'                 => $basic['dob'] ?? null,
                'birth_time'          => $d['astronomic']['birth_time'] ?? null,
                'birth_city'          => $d['astronomic']['birth_city'] ?? null,
                'birth_place'         => $d['astronomic']['birth_place'] ?? null,
                'star'                => $d['astronomic']['star'] ?? null,
                'rasi'                => $d['astronomic']['rasi'] ?? null,
                'nakshatra'           => $d['astronomic']['nakshatra'] ?? null,
                'dosham'              => $d['astronomic']['dosham'] ?? null,
                'paksha'              => $d['astronomic']['paksha'] ?? null,
                'tithi'               => $d['astronomic']['tithi'] ?? null,
                'ganam'               => $d['astronomic']['ganam'] ?? null,
                'nadi'                => $d['astronomic']['nadi'] ?? null,
                'lakknam'             => $d['astronomic']['lakknam'] ?? null,
                'padam'               => $d['astronomic']['padam'] ?? null,
                'horoscope_matching'  => $d['astronomic']['horoscope_matching'] ?? null,
                'directional_balance' => $d['astronomic']['directional_balance'] ?? null,
            ],

            'physical' => $d['physical'] ?? [],
            'career'   => array_merge($d['career'] ?? [], [
             'education'    => $d['education']['education'] ?? null,
             'study_details'=> $d['education']['study_details'] ?? null,
            ]),

            'contact' => [
                'mobile'           => $d['location']['mobile'] ?? null,
                'alternate_number' => $d['location']['alternate_number'] ?? null,
                'landline'         => $d['location']['landline'] ?? null,
                'address'          => $d['location']['address'] ?? null,
                'current_city'     => $d['location']['current_city'] ?? $d['location']['city'] ?? null,
                'city'             => $d['location']['city'] ?? null,
                'state'            => $d['location']['state'] ?? null,
                'country'          => $d['location']['country'] ?? null,
                'postal_code'      => $d['location']['postal_code'] ?? null,
                'native_place'     => $d['location']['native_place'] ?? null,
            ],

            'partner' => [
               'preferred_age'    => $d['partner']['preferred_age'] ?? null,
                'preferred_height' => $d['partner']['preferred_height'] ?? null,
                'education'        => $d['partner']['education'] ?? null,
                'caste'            => $d['partner']['caste'] ?? null,
                'marital_status'   => $d['partner']['marital_status'] ?? null,
                'physical_status'  => $d['partner']['physical_status'] ?? null,
                'body_type'        => $d['partner']['body_type'] ?? null,
                'dosham'           => $d['partner']['dosham'] ?? null,
                'type_of_dosham'   => $d['partner']['type_of_dosham'] ?? null,
                'other_dosham'     => $d['partner']['other_dosham'] ?? null,
                'profession'       => $d['partner']['profession'] ?? null,
                'expectations'     => $d['partner']['expectations'] ?? null,
                'about_partner'    => $d['partner']['about_partner'] ?? null,
            ],
            'family'             => $d['family'] ?? null,
            'partner_preference' => $d['partner'] ?? null,
            'horoscope_boxes'    => $d['horoscope_boxes'] ?? [],
            'photos'             => $d['images'] ?? [],

            'quota' => $d['current_user_membership'] ?? [],
        ];

        if (!$isOwn) {
            $this->api->authPost('interaction/consume-view', [
            'profile_id' => (int)$id,
        ]);
        }

        return view('members.show', compact('member'));
    }

    public function sendInterest(Request $request, $id)
    {
        $profileId = $request->input('profile_id');

        if (!$profileId) {
            return response()->json(['message' => 'Profile not found.'], 422);
        }

        $response = $this->api->authPost('interaction/interest', [
            'receiver_profile_id' => $profileId,
        ]);

        if ($response['success'] ?? false) {
            return response()->json(['message' => 'Interest sent successfully!']);
        }

        $msg    = $response['message'] ?? 'Could not send interest. Please try again.';
        $status = ($response['status_code'] ?? 422) === 409 ? 409 : 422;
        return response()->json(['message' => $msg], $status);
    }

    public function shortlist(Request $request, $id)
    {
        $profileId = $request->input('profile_id');

        if (!$profileId) {
            return response()->json(['message' => 'Profile not found.'], 422);
        }

        $response = $this->api->authPost('interaction/toggle-action', [
            'to_profile_id' => $profileId,
            'action_type'   => 'shortlist',
        ]);

        if ($response['success'] ?? false) {
            $active = $response['data']['active'] ?? false;
            return response()->json([
                'message' => $active ? 'Added to shortlist.' : 'Removed from shortlist.',
                'active'  => $active,
            ]);
        }

        $msg = $response['message'] ?? 'Could not update shortlist.';
        return response()->json(['message' => $msg], 422);
    }
    
    
    public function shortlisted(Request $request)
{
    $response = $this->api->authGet('interaction/shortlisted');

    $items = $response['data'] ?? [];

    $profiles = array_map(function ($item) {
    $profile = $item['to_profile'] ?? [];
    $photo = $profile['profile_photo'] ?? null;
    if ($photo && !str_starts_with($photo, 'http')) {
        $photo = 'https://api.thirumanam.info/' . $photo;
    }
    return [
        'profile_id' => $profile['id'] ?? null,
        'member_id'  => $profile['member']['id'] ?? null,
        'member_no'  => $profile['member']['member_no'] ?? null,
        'name'       => $profile['user']['name'] ?? 'Unknown',
        'gender'     => $profile['gender'] ?? null,
        'age'        => $profile['age'] ?? null,
        'city'       => $profile['location']['city'] ?? $profile['city'] ?? null,
        'education'  => $profile['education']['education'] ?? $profile['education'] ?? null,
        'occupation' => $profile['occupation'] ?? null,
        'photo'      => $photo,
        'created_at' => $item['created_at'] ?? null,
    ];
}, $items);

    return view('members.shortlisted', compact('profiles'));
}

    public function block(Request $request, $id)
    {
        $profileId = $request->input('profile_id');

        if (!$profileId) {
            return response()->json(['message' => 'Profile not found.'], 422);
        }

        $response = $this->api->authPost('interaction/toggle-action', [
            'to_profile_id' => $profileId,
            'action_type'   => 'block',
        ]);

        if ($response['success'] ?? false) {
            $active = $response['data']['active'] ?? false;
            return response()->json([
                'message' => $active ? 'Member blocked.' : 'Member unblocked.',
                'active'  => $active,
            ]);
        }

        $msg = $response['message'] ?? 'Could not block member.';
        return response()->json(['message' => $msg], 422);
    }
    public function follow(Request $request, $id)
{
    $profileId = $request->input('profile_id');

    if (!$profileId) {
        return response()->json(['message' => 'Profile not found.'], 422);
    }

    $response = $this->api->authPost('interaction/toggle-action', [
        'to_profile_id' => $profileId,
        'action_type'   => 'follow',
    ]);

    if ($response['success'] ?? false) {
        $active = $response['data']['active'] ?? false;
        return response()->json([
            'message' => $active ? 'Following this member.' : 'Unfollowed.',
            'active'  => $active,
        ]);
    }

    return response()->json(['message' => $response['message'] ?? 'Could not update follow.'], 422);
}

public function report(Request $request, $id)
{
    $profileId = $request->input('profile_id');
    $reason    = $request->input('reason', 'Reported by user');

    if (!$profileId) {
        return response()->json(['message' => 'Profile not found.'], 422);
    }

    $response = $this->api->authPost('interaction/report', [
        'reported_profile_id' => $profileId,
        'reason'              => $reason,
    ]);

    if ($response['success'] ?? false) {
        return response()->json(['message' => 'Profile reported successfully.']);
    }

    return response()->json(['message' => $response['message'] ?? 'Could not report profile.'], 422);
}
}