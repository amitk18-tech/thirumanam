<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Bits\Package\Responses\ApiResponse;

class DailyRecommendationsController extends Controller
{
    /**
     * Get daily recommendations for the authenticated user
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            // Get authenticated user's profile
            $user = Auth::user();
            
            if (!$user) {
                return ApiResponse::error('User not authenticated', null, 401);
            }

            // Get user's profile to understand preferences
            $userProfile = Profile::where('user_id', $user->id)->first();

            if (!$userProfile) {
                return ApiResponse::error('User profile not found', null, 404);
            }

            // Get user's partner preferences if available
            $partnerPreference = $userProfile->partnerPreference;

            // Build query for recommendations
            $query = Member::with([
                'profile',
                'profile.user',
                'profile.photo',
                'membership'
            ])
            ->where('status', 'active')
            ->where('is_matched', false)
            ->whereHas('profile', function ($q) use ($userProfile) {
                // Exclude user's own profile
                $q->where('id', '!=', $userProfile->id);
                
                // Match opposite gender
                if ($userProfile->gender === 'male') {
                    $q->where('gender', 'female');
                } elseif ($userProfile->gender === 'female') {
                    $q->where('gender', 'male');
                }
            });

            // Apply partner preferences if available
            if ($partnerPreference) {
                $query->whereHas('profile', function ($q) use ($partnerPreference) {
                    // Age preference
                    if ($partnerPreference->preferred_age_min && $partnerPreference->preferred_age_max) {
                        $q->whereBetween('age', [
                            $partnerPreference->preferred_age_min,
                            $partnerPreference->preferred_age_max
                        ]);
                    }

                    // Height preference
                    if ($partnerPreference->preferred_height_min && $partnerPreference->preferred_height_max) {
                        $q->whereBetween('height', [
                            $partnerPreference->preferred_height_min,
                            $partnerPreference->preferred_height_max
                        ]);
                    }

                    // Marital status preference
                    if ($partnerPreference->marital_status_preference) {
                        $q->where('marital_status', $partnerPreference->marital_status_preference);
                    }

                    // Education preference
                    if ($partnerPreference->education_preference) {
                        $q->where('education', 'like', '%' . $partnerPreference->education_preference . '%');
                    }
                });
            }

            // Get recommendations (limit to 20)
            $recommendations = $query->inRandomOrder()
                ->limit(20)
                ->get();

            // Format the response
            $data = $recommendations->map(function ($member) {
                $profile = $member->profile;
                $user = $profile->user ?? null;
                $photo = $profile->photo ?? null;

                return [
                    'id' => (string) $member->id,
                    'title' => $user->name ?? 'Unknown',
                    'image' => $photo && $photo->photo_url 
                        ? url($photo->photo_url) 
                        : null,
                    'subtitle' => sprintf(
                        '%s Years / %s / %s',
                        $profile->age ?? 'N/A',
                        $profile->occupation ?? 'N/A',
                        $profile->city ?? 'N/A'
                    ),
                    'height' => $profile->height ? $profile->height . ' cm' : 'N/A',
                    'age' => $profile->age ?? 0,
                    'price' => 'View profile',
                    // Additional fields for detailed view
                    'gender' => $profile->gender ?? null,
                    'marital_status' => $profile->marital_status ?? null,
                    'education' => $profile->education ?? null,
                    'occupation' => $profile->occupation ?? null,
                    'city' => $profile->city ?? null,
                    'state' => $profile->state ?? null,
                    'country' => $profile->country ?? null,
                ];
            });

            Log::info('Daily recommendations fetched', [
                'user_id' => $user->id,
                'count' => $data->count(),
            ]);

            return ApiResponse::success('Daily recommendations fetched successfully', $data);

        } catch (\Throwable $e) {
            Log::error('Failed to fetch daily recommendations', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return ApiResponse::error('Failed to fetch daily recommendations', $e->getMessage(), 500);
        }
    }
}
