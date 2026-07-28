<?php

namespace App\Http\Controllers\Notifications;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Bits\Package\Responses\ApiResponse;
use App\Models\ProfileAction;
use App\Models\Interest;
use Bits\Package\Controllers\BaseController;

class NotificationController extends BaseController
{
    private function buildNotifications($user)
    {
        if (!$user || !$user->profile) {
            return collect();
        }

        $profileId = $user->profile->id;
        $notifications = collect();

        $activeMember = $user->profile->activeMember;

        if ($activeMember) {
            if ($activeMember->end_date && now()->diffInDays($activeMember->end_date, false) <= 7 && now()->diffInDays($activeMember->end_date, false) >= 0) {
                $daysLeft = (int) now()->diffInDays($activeMember->end_date);

                $notifications->push([
                    'type' => 'expiry_alert',
                    'title' => 'Membership Expiring Soon!',
                    'body' => $daysLeft === 0
                        ? "Your membership expires today. Renew now to skip interruption."
                        : "Your membership expires in {$daysLeft} days. Renew now to skip interruption.",
                    'data' => [
                        'days_left' => $daysLeft,
                        'expiry_date' => $activeMember->end_date->format('Y-m-d'),
                        'membership_slug' => $activeMember->membership->slug ?? 'default'
                    ],
                    'created_at' => now(),
                    'read' => false,
                ]);
            }
        }

        $followers = ProfileAction::with(['fromProfile.user'])
            ->where('to_profile_id', $profileId)
            ->where('action_type', 'follow')
            ->where('created_at', '>=', now()->subDays(30))
            ->latest()
            ->get();

        foreach ($followers as $follow) {
            if ($follow->fromProfile && $follow->fromProfile->user) {
                $notifications->push([
                    'type' => 'new_follower',
                    'title' => 'New Follower',
                    'body' => "{$follow->fromProfile->user->name} started following you.",
                    'data' => [
                        'follower_profile_id' => $follow->from_profile_id,
                        'follower_name' => $follow->fromProfile->user->name,
                        'follower_photo' => $follow->fromProfile->profile_photo
                            ? url($follow->fromProfile->profile_photo)
                            : null
                    ],
                    'created_at' => $follow->created_at,
                    'read' => false,
                ]);
            }
        }

        $interests = Interest::with(['sender.user'])
            ->where('receiver_profile_id', $profileId)
            ->where('created_at', '>=', now()->subDays(30))
            ->latest()
            ->get();

        foreach ($interests as $interest) {
            if ($interest->sender && $interest->sender->user) {
                $notifications->push([
                    'type' => 'interest_received',
                    'title' => 'Interest Received',
                    'body' => "{$interest->sender->user->name} sent you an interest.",
                    'data' => [
                        'sender_profile_id' => $interest->sender_profile_id,
                        'sender_name' => $interest->sender->user->name,
                        'interest_status' => $interest->status,
                        'sender_photo' => $interest->sender->profile_photo
                            ? url($interest->sender->profile_photo)
                            : null
                    ],
                    'created_at' => $interest->created_at,
                    'read' => false,
                ]);
            }
        }

        return $notifications;
    }

    /**
     * list all notifications (Expiry, Follows, Interests)
     */
    public function index(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user || !$user->profile) {
                return ApiResponse::success('No notifications found', []);
            }

            $notifications = $this->buildNotifications($user);

            // Sort by Date Descending
            $sortedNotifications = $notifications->sortByDesc('created_at')->values();

            return ApiResponse::success('Notifications fetched successfully', $sortedNotifications);
        } catch (\Throwable $e) {
            Log::error('Notification Fetch Failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return ApiResponse::error('Failed to fetch notifications', $e->getMessage(), 500);
        }
    }

    /**
     * unread notifications count
     */
    public function unreadCount(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user || !$user->profile) {
                return ApiResponse::success('Notification unread count fetched successfully', ['count' => 0]);
            }

            $notifications = $this->buildNotifications($user);
            $count = $notifications->where('read', false)->count();

            return ApiResponse::success('Notification unread count fetched successfully', ['count' => $count]);
        } catch (\Throwable $e) {
            Log::error('Notification Count Fetch Failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return ApiResponse::error('Failed to fetch notification unread count', $e->getMessage(), 500);
        }
    }
}
