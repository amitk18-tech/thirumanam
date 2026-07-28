<?php

namespace App\Http\Controllers;

use App\Models\Interest;
use App\Models\ProfileAction;
use App\Models\ProfileReport;
use Bits\Package\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Profile;

class ProfileInteractionController extends Controller
{
    /**
     * Get members with interactions (e.g. reported)
     */
    public function index(Request $request)
    {
        try {
            $userRole = $request->user()->role?->name ?? 'user';

            if (!in_array($userRole, ['admin', 'super admin', 'staff'])) {
                return ApiResponse::error('Unauthorized access', null, 403);
            }

            $status = $request->get('status');
            $perPage = (int) $request->get('per_page', 20);
            $page = (int) $request->get('page', 1);
            $search = trim($request->get('search') ?? $request->get('name') ?? '');

            // Always fetch reported members for the interaction endpoint
            $query = ProfileReport::query();

            // Join with the reported profile and user to allow searching by member_no, name, phone
            $query->with([
                'reportedProfile' => function ($q) {
                    $q->with(['user', 'member', 'familyDetail'])
                        ->withCount([
                            'followers',
                            'following',
                            'interestsSent',
                            'interestsReceived',
                            'blockedProfiles',
                            'shortlistedProfiles',
                        ]);
                },
                'reportedByProfile.user',
                'reportedByProfile.member'
            ]);


            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('reportedProfile.member', function ($m) use ($search) {
                        $m->where('member_no', 'LIKE', "%$search%");
                    })
                        ->orWhereHas('reportedProfile.user', function ($u) use ($search) {
                            $u->where('name', 'LIKE', "%$search%")
                                ->orWhere('phone', 'LIKE', "%$search%");
                        })
                        ->orWhereHas('reportedByProfile.user', function ($u) use ($search) {
                            $u->where('name', 'LIKE', "%$search%");
                        })
                        ->orWhereHas('reportedByProfile.member', function ($m) use ($search) {
                            $m->where('member_no', 'LIKE', "%$search%");
                        });
                });
            }

            $paginated = $query->paginate($perPage, ['*'], 'page', $page);

            $data = collect($paginated->items())->map(function ($report) {
                $reportedProfile = $report->reportedProfile;
                $member = $reportedProfile?->member;

                $reportedByProfile = $report->reportedByProfile;
                $reportedByMember = $reportedByProfile?->member;

                return [
                    'id' => $report->id, // Report ID
                    'report_reason' => $report->reason,
                    'report_details' => $report->reason,
                    'report_description' => $report->description,
                    'reported_date' => optional($report->created_at)->format('d-m-Y H:i:s'),
                    'date' => optional($report->created_at)->format('d-m-Y H:i:s'),
                    'reported_by_name' => $reportedByProfile?->user?->name ?? 'Unknown',
                    'reported_by_member_no' => $reportedByMember?->member_no ?? 'Unknown',
                    'reported' => ($reportedByProfile?->user?->name ?? 'Unknown') . ' (' . ($reportedByMember?->member_no ?? 'N/A') . ')',

                    // Profile Data (Mapped to match AllMembersComponent structure)
                    'profile_id' => $reportedProfile?->id ?? null,
                    'name' => trim($member?->profile->user?->name ?? 'Unknown'),
                    'profile_gender' => $reportedProfile?->gender ?? null,
                    'membership_slug' => $member?->membership?->name ?? null,
                    'profile_marital_status' => $reportedProfile?->marital_status ?? null,
                    'profiles_used' => $member?->profiles_view_remaining ?? 0,
                    'profiles_view_remaining' => $member?->profiles_view_remaining ?? 0,
                    'is_reported' => $member?->is_reported ?? false,
                    'member_no' => $member?->member_no ?? 'N/A',
                    'member_created_date' => optional($member?->created_at)->format('d-m-Y H:i:s'),
                    'profile_photo' => $reportedProfile?->profile_photo ?: (strtolower($reportedProfile?->gender ?? '') === 'female' ? 'storage/default_image/default_female.jpg' : 'storage/default_image/default_male.jpg'),
                    'phone' => $reportedProfile?->user?->phone ?? null,
                    'is_renewed' => $member?->isRenewed ?? 0,
                    'status' => $member?->status ?? 'Unknown',
                ];
            });

            return ApiResponse::success('Reported members fetched successfully', [
                'current_page' => $paginated->currentPage(),
                'per_page' => $paginated->perPage(),
                'total' => $paginated->total(),
                'last_page' => $paginated->lastPage(),
                'data' => $data,
            ]);
        } catch (\Throwable $e) {
            return ApiResponse::error('Failed to fetch', $e->getMessage(), 500);
        }
    }

    /**
     * Send an interest to another profile.
     */

    public function sendInterest(Request $request)
    {
        $validated = $request->validate([
            'receiver_profile_id' => 'required|exists:profiles,id',
        ]);

        $senderProfile = $request->user()->profile;

        if (!$senderProfile) {
            return ApiResponse::error('Profile not found', null, 404);
        }

        // ✅ already sent check (FIXED)
        $exists = Interest::where([
            'sender_profile_id' => $senderProfile->id,
            'receiver_profile_id' => $validated['receiver_profile_id'],
        ])->exists();

        if ($exists) {
            return ApiResponse::error('Interest already sent', null, 409);
        }

        $member = $senderProfile->activeMember;

        if (!$member || $member->sent_interest_remaining <= 0) {
            return ApiResponse::customError(
                'Quota exceeded or no active membership',
                ['upgrade_required' => true],
                403
            );
        }   

        // ✅ create interest (FIXED)
        Interest::create([
            'sender_profile_id' => $senderProfile->id,
            'receiver_profile_id' => $validated['receiver_profile_id'],
            'status' => 'pending',
        ]);

        $member->decrement('sent_interest_remaining');

        return ApiResponse::success('Interest sent', [
            'remaining' => $member->sent_interest_remaining,
            'allowed' => $member->sent_interest_allowed,
        ]);
    }


    /**
     * Get follow and follower counts for frontend.
     */
    public function getFollowStats(Request $request)
    {
        $profile = $request->user()->profile;

        if (!$profile) {
            return ApiResponse::error('Profile not found', null, 404);
        }

        $relations = [
            'fromProfile.user',
            'fromProfile.member',
            'toProfile.user',
            'toProfile.member',
        ];

        /* ================= FOLLOW ================= */

        // Current user-ai yaar follow panninaanga
        $followers = ProfileAction::where('to_profile_id', $profile->id)
            ->where('action_type', 'follow')
            ->with($relations)
            ->latest()
            ->get();

        // Current user yaar yaarai follow pannirukaaru
        $following = ProfileAction::where('from_profile_id', $profile->id)
            ->where('action_type', 'follow')
            ->with($relations)
            ->latest()
            ->get();

        /* ================= SHORTLIST ================= */

        // Current user yaar yaarai shortlist pannirukaaru
        $shortlisted = ProfileAction::where('from_profile_id', $profile->id)
            ->where('action_type', 'shortlist')
            ->with($relations)
            ->latest()
            ->get();

        // Current user-ai yaar shortlist panninaanga
        $shortlistedBy = ProfileAction::where('to_profile_id', $profile->id)
            ->where('action_type', 'shortlist')
            ->with($relations)
            ->latest()
            ->get();

        /* ================= BLOCK ================= */

        // Current user yaar yaarai block pannirukaaru
        $blocked = ProfileAction::where('from_profile_id', $profile->id)
            ->where('action_type', 'block')
            ->with($relations)
            ->latest()
            ->get();

        // Current user-ai yaar block panninaanga
        $blockedBy = ProfileAction::where('to_profile_id', $profile->id)
            ->where('action_type', 'block')
            ->with($relations)
            ->latest()
            ->get();

        return ApiResponse::success('User relationship stats fetched successfully', [
            /* FOLLOW */
            'followers_count' => $followers->count(),
            'following_count' => $following->count(),
            'followers' => $followers,
            'following' => $following,

            /* SHORTLIST */
            'shortlisted_count' => $shortlisted->count(),
            'shortlisted_by_count' => $shortlistedBy->count(),
            'shortlisted' => $shortlisted,
            'shortlisted_by' => $shortlistedBy,

            /* BLOCK */
            'blocked_count' => $blocked->count(),
            'blocked_by_count' => $blockedBy->count(),
            'blocked' => $blocked,
            'blocked_by' => $blockedBy,
        ]);
    }




    public function toggleAction(Request $request)
    {
        $validated = $request->validate([
            'to_profile_id' => 'required|exists:profiles,id',
            'action_type' => 'required|in:shortlist,follow,block',
        ]);

        $fromProfile = $request->user()->profile;

        if (!$fromProfile) {
            return ApiResponse::error('User profile not found', null, 404);
        }

        $action = ProfileAction::where('from_profile_id', $fromProfile->id)
            ->where('to_profile_id', $validated['to_profile_id'])
            ->where('action_type', $validated['action_type'])
            ->first();

        if ($action) {
            // 🔁 UNDO
            $action->delete();

            return ApiResponse::success('Action removed', [
                'active' => false,
                'action_type' => $validated['action_type']
            ]);
        }

        // ➕ ADD
        ProfileAction::create([
            'from_profile_id' => $fromProfile->id,
            'to_profile_id' => $validated['to_profile_id'],
            'action_type' => $validated['action_type'],
        ]);

        return ApiResponse::success('Action added', [
            'active' => true,
            'action_type' => $validated['action_type']
        ]);
    }


    /**
     * Get shortlisted profiles.
     */
    public function getShortlisted(Request $request)
    {
        $profile = $request->user()->profile;
        if (!$profile) {
            return ApiResponse::error('Profile not found', null, 404);
        }

        $shortlisted = ProfileAction::where('from_profile_id', $profile->id)
            ->where('action_type', 'shortlist')
            ->with('toProfile.user', 'toProfile.member', 'toProfile.education', 'toProfile.location')
            ->latest()
            ->get();

        return ApiResponse::success('Shortlisted profiles fetched successfully', $shortlisted);
    }

    /**
     * Create a shortlist entry.
     */
    public function createShortlist(Request $request)
    {
        $validated = $request->validate([
            'to_profile_id' => 'required|exists:profiles,id',
        ]);

        $fromProfile = $request->user()->profile;

        if (!$fromProfile) {
            return ApiResponse::error('User profile not found', null, 404);
        }

        // Check if already shortlisted
        $existingShortlist = ProfileAction::where('from_profile_id', $fromProfile->id)
            ->where('to_profile_id', $validated['to_profile_id'])
            ->where('action_type', 'shortlist')
            ->first();

        if ($existingShortlist) {
            return ApiResponse::customError('Profile already shortlisted', null, 409);
        }

        $shortlist = ProfileAction::create([
            'from_profile_id' => $fromProfile->id,
            'to_profile_id' => $validated['to_profile_id'],
            'action_type' => 'shortlist',
        ]);

        return ApiResponse::success('Profile shortlisted successfully', $shortlist);
    }

    /**
     * Follow a profile.
     */
    public function createFollower(Request $request)
    {
        $validated = $request->validate([
            'followed_profile_id' => 'required|exists:profiles,id',
        ]);

        $fromProfile = $request->user()->profile;

        if (!$fromProfile) {
            return ApiResponse::error('User profile not found', null, 404);
        }

        // Check if already following
        $existingFollow = ProfileAction::where('from_profile_id', $fromProfile->id)
            ->where('to_profile_id', $validated['followed_profile_id'])
            ->where('action_type', 'follow')
            ->first();

        if ($existingFollow) {
            return ApiResponse::customError('Profile already followed', null, 409);
        }

        $follow = ProfileAction::create([
            'from_profile_id' => $fromProfile->id,
            'to_profile_id' => $validated['followed_profile_id'],
            'action_type' => 'follow',
        ]);

        return ApiResponse::success('Profile followed successfully', $follow);
    }

    /**
     * Get followers of the current user's profile.
     */
    public function getFollowers(Request $request)
    {
        $profile = $request->user()->profile;
        if (!$profile) {
            return ApiResponse::error('Profile not found', null, 404);
        }

        $followers = ProfileAction::where('to_profile_id', $profile->id)
            ->where('action_type', 'follow')
            ->with('fromProfile.user', 'fromProfile.member', 'fromProfile.education', 'fromProfile.location')
            ->latest()
            ->get();

        return ApiResponse::success('Followers fetched successfully', $followers);
    }

    /**
     * Get profiles followed by the current user.
     */
    public function getFollowing(Request $request)
    {
        $profile = $request->user()->profile;
        if (!$profile) {
            return ApiResponse::error('Profile not found', null, 404);
        }

        $following = ProfileAction::where('from_profile_id', $profile->id)
            ->where('action_type', 'follow')
            ->with('toProfile.user', 'toProfile.member', 'toProfile.education', 'toProfile.location')
            ->latest()
            ->get();

        return ApiResponse::success('Following profiles fetched successfully', $following);
    }





    public function consumeProfileView(Request $request)
    {
        $viewer = $request->user();
        $viewerMember = $viewer->profile?->activeMember;

        if (!$viewerMember) {
            return ApiResponse::error('Active member profile not found', null, 404);
        }

        // 1. Check Quota
        $allowed = $viewerMember->profiles_view_allowed ?? 0;
        $remaining = $viewerMember->profiles_view_remaining ?? 0;

        if ($remaining <= 0 && $remaining != -1) {
            return ApiResponse::customError('Profile view quota exceeded', null, 403);
        }

        // 2. Decrement Remaining
        if ($remaining != -1) {
            $viewerMember->decrement('profiles_view_remaining');
            $remaining--;
        }

        return ApiResponse::success('Profile view consumed', [
            'profiles_view_remaining' => $remaining,
            'profiles_view_allowed' => $allowed,
        ]);
    }


    /**
     * Respond to an interest (accept/reject).
     */
    public function respondToInterest(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        $interest = Interest::findOrFail($id);

        // Optional: specific check if the current user is really the receiver
        // if ($interest->receiver_profile_id !== $request->user()->profile->id) { abort(403); }

        $interest->update([
            'status' => $validated['status'],
            'responded_at' => now(),
        ]);

        return ApiResponse::success('Interest status updated', $interest);
    }

    /**
     * Perform an action on a profile (shortlist, follow, block).
     */
    public function performAction(Request $request)
    {
        $validated = $request->validate([
            // 'from_profile_id' => 'required|exists:profiles,id',
            'to_profile_id' => 'required|exists:profiles,id',
            'action_type' => 'required|in:shortlist,follow,block',
        ]);

        $fromProfile = $request->user()->profile;

        if (!$fromProfile) {
            return ApiResponse::error('User profile not found', null, 404);
        }

        $action = ProfileAction::updateOrCreate(
            [
                'from_profile_id' => $fromProfile->id,
                'to_profile_id' => $validated['to_profile_id'],
                'action_type' => $validated['action_type'],
            ]
        );

        return ApiResponse::success('Action performed successfully', $action);
    }

    /**
     * Undo an action (unshortlist, unfollow, unblock).
     */
    public function undoAction(Request $request)
    {
        $validated = $request->validate([
            // 'from_profile_id' => 'required|exists:profiles,id',
            'to_profile_id' => 'required|exists:profiles,id',
            'action_type' => 'required|in:shortlist,follow,block',
        ]);

        $fromProfile = $request->user()->profile;

        if (!$fromProfile) {
            return ApiResponse::error('User profile not found', null, 404);
        }

        ProfileAction::where('from_profile_id', $fromProfile->id)
            ->where('to_profile_id', $validated['to_profile_id'])
            ->where('action_type', $validated['action_type'])
            ->delete();

        return ApiResponse::success('Action undone successfully');
    }

    /**
     * Report a profile.
     */
    public function reportProfile(Request $request)
    {
        $validated = $request->validate([
            // 'reported_by_profile_id' => 'required|exists:profiles,id',
            'reported_profile_id' => 'required|exists:profiles,id',
            'reason' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $reporterProfile = $request->user()->profile;
        if (!$reporterProfile) {
            return ApiResponse::error('User profile not found', null, 404);
        }

        $report = ProfileReport::create([
            'reported_by_profile_id' => $reporterProfile->id,
            'reported_profile_id' => $validated['reported_profile_id'],
            'reason' => $validated['reason'],
            'description' => $validated['description'] ?? null,
        ]);

        return ApiResponse::success('Profile reported successfully', $report);
    }

    /**
     * Get interests (Sent or Received).
     */
    public function getInterests(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:sent,received',
            'status' => 'nullable|in:pending,accepted,rejected,all'
        ]);

        $profile = $request->user()->profile;
        if (!$profile) {
            return ApiResponse::error('Profile not found', null, 404);
        }



        $type = $validated['type'];
        $status = $validated['status'] ?? 'all';

        $query = Interest::query();

        if ($type === 'sent') {
            $query->where('sender_profile_id', $profile->id)->with('receiver.user', 'receiver.member');
        } else {
            $query->where('receiver_profile_id', $profile->id)->with('sender.user', 'sender.member');
        }

        if ($status !== 'all') {
            $query->where('status', $status);
        }



        $interests = $query->latest()->get();



        return ApiResponse::success('Interests fetched successfully', $interests);
    }

    /**
     * Get followers or following list.
     */
    public function getFollows(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:followers,following',
        ]);

        $profile = $request->user()->profile;
        if (!$profile) {
            return ApiResponse::error('Profile not found', null, 404);
        }

        $type = $validated['type'];
        $query = ProfileAction::query()->where('action_type', 'follow');

        if ($type === 'followers') {
            // Who follows ME? (to_profile_id = ME)
            $query->where('to_profile_id', $profile->id)->with('fromProfile.user', 'fromProfile.member', 'fromProfile.education', 'fromProfile.location');
        } else {
            // Who do I follow? (from_profile_id = ME)
            $query->where('from_profile_id', $profile->id)->with('toProfile.user', 'toProfile.member', 'toProfile.education', 'toProfile.location');
        }

        $connections = $query->latest()->get();

        return ApiResponse::success('Connections fetched successfully', $connections);
    }

    public function createBlock(Request $request)
    {
        $validated = $request->validate([
            'to_profile_id' => 'required|exists:profiles,id',
        ]);

        $fromProfile = $request->user()->profile;

        if (!$fromProfile) {
            return ApiResponse::error('User profile not found', null, 404);
        }

        // Check if already blocked
        $existingBlock = ProfileAction::where('from_profile_id', $fromProfile->id)
            ->where('to_profile_id', $validated['to_profile_id'])
            ->where('action_type', 'block')
            ->first();

        if ($existingBlock) {
            return ApiResponse::customError('Profile already blocked', null, 409);
        }

        $block = ProfileAction::create([
            'from_profile_id' => $fromProfile->id,
            'to_profile_id' => $validated['to_profile_id'],
            'action_type' => 'block',
        ]);

        return ApiResponse::success('Profile blocked successfully', $block);
    }

    public function getBlockedList(Request $request)
    {
        try {
            $id = $request->get('user_id') ?? $request->get('profile_id');

            if ($id) {
                $user = User::find($id);
                $profile = $user?->profile;

                if (!$profile) {
                    $profile = Profile::find($id);
                }

                if (!$profile) {
                    return ApiResponse::error("Profile not found for the provided ID: {$id}", null, 404);
                }
            } else {
                $user = $request->user();
                $profile = $user?->profile;
            }

            if (!$profile) {
                return ApiResponse::error('Profile not found', null, 404);
            }

            // 1️⃣ I blocked
            $blockedByMe = ProfileAction::where('from_profile_id', $profile->id)
                ->where('action_type', 'block')
                ->with(['toProfile.user', 'toProfile.member', 'toProfile.familyDetail'])
                ->latest()
                ->get();

            // 2️⃣ They blocked me
            $blockedMe = ProfileAction::where('to_profile_id', $profile->id)
                ->where('action_type', 'block')
                ->with(['fromProfile.user', 'fromProfile.member', 'fromProfile.familyDetail'])
                ->latest()
                ->get();

            $blockedByMeData = $blockedByMe->map(function ($action) {
                $targetProfile = $action->toProfile;

                return [
                    'type' => 'blocked_by_me',
                    'id' => $targetProfile->id,
                    'user_id' => $targetProfile->user?->id,
                    'member_no' => $targetProfile->member?->member_no,
                    'name' => $targetProfile->user?->name,
                    'profile_photo' => $targetProfile->profile_photo,
                    'gender' => $targetProfile->gender,
                    'age' => $targetProfile->age,
                    'city' => $targetProfile->city,
                    'occupation' => $targetProfile->occupation,
                    'blocked_at' => $action->created_at->format('d-m-Y H:i A'),
                ];
            });

            $blockedMeData = $blockedMe->map(function ($action) {
                $targetProfile = $action->fromProfile;

                return [
                    'type' => 'blocked_me',
                    'id' => $targetProfile->id,
                    'user_id' => $targetProfile->user?->id,
                    'member_no' => $targetProfile->member?->member_no,
                    'name' => $targetProfile->user?->name,
                    'profile_photo' => $targetProfile->profile_photo,
                    'gender' => $targetProfile->gender,
                    'age' => $targetProfile->age,
                    'city' => $targetProfile->city,
                    'occupation' => $targetProfile->occupation,
                    'blocked_at' => $action->created_at->format('d-m-Y H:i A'),
                ];
            });

            return ApiResponse::success('Blocked profiles fetched successfully', [
                'blocked_by_me' => $blockedByMeData,
                'blocked_me' => $blockedMeData,
            ]);

        } catch (\Throwable $e) {
            Log::error('getBlockedList FAILED', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return ApiResponse::error('Failed to fetch blocked profiles', $e->getMessage(), 500);
        }
    }

    public function shorlisted(Request $request)
    {
        $profile = $request->user()->profile;
        if (!$profile) {
            return ApiResponse::error('Profile not found', null, 404);
        }

        $shortlisted = ProfileAction::where('from_profile_id', $profile->id)
            ->where('action_type', 'shortlist')
            ->with('toProfile.user', 'toProfile.member', 'toProfile.familyDetail')
            ->latest()
            ->get();

        return ApiResponse::success('Shortlisted profiles fetched successfully', $shortlisted);
    }
}