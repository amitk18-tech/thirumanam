<?php

namespace App\Http\Controllers\Chat;

use Bits\Package\Repositories\BaseRepository;
use Bits\Package\Services\BaseService;
use Bits\Package\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Profile;
use Bits\Package\Responses\ApiResponse;
use App\Models\Member;

class MessageController extends BaseController
{
    public function __construct()
    {
        $this->policyModel = Message::class;

        $this->middleware(function ($request, $next) {
            $authUser = Auth::user();

            Log::info('MESSAGE: Authenticated User', [
                'user_id' => $authUser?->id,
            ]);

            $this->service = new BaseService(
                new BaseRepository(new Message(), null)
            );

            return $next($request);
        });
    }

    /* =====================================================
       SEND MESSAGE
    ===================================================== */

    // public function sendMessage(Request $request)
    // {
    //     $data = $request->validate([
    //         'receiver_profile_id' => 'required|exists:profiles,id',
    //         'message_text' => 'required|string',
    //         'message_type' => 'nullable|in:text,image,video',
    //     ]);

    //     $user = Auth::user();
    //     $senderProfile = $user->profile;

    //     if (!$senderProfile) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Profile not found',
    //         ], 403);
    //     }

    //     if ($senderProfile->id == $data['receiver_profile_id']) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Cannot send message to yourself',
    //         ], 422);
    //     }

    //     $message = Message::create([
    //         'sender_profile_id' => $senderProfile->id,
    //         'receiver_profile_id' => $data['receiver_profile_id'],
    //         'message_text' => $data['message_text'],
    //         'message_type' => $data['message_type'] ?? 'text',
    //         'is_read' => false,
    //     ]);

    //     return response()->json([
    //         'success' => true,
    //         'data' => $message,
    //         'message' => 'Message sent successfully',
    //     ]);
    // }

    public function sendMessage(Request $request)
{
    $data = $request->validate([
        'receiver_profile_id' => 'required|exists:profiles,id',
        'message_text' => 'required|string',
        'message_type' => 'nullable|in:text,image,video',
    ]);

    $user = Auth::user();
    $senderProfile = $user->profile;

    if (!$senderProfile) {
        return response()->json([
            'success' => false,
            'message' => 'Profile not found',
        ], 403);
    }

    if ($senderProfile->id == $data['receiver_profile_id']) {
        return response()->json([
            'success' => false,
            'message' => 'Cannot message yourself',
        ], 422);
    }

    // 🔐 ACTIVE MEMBER CHECK
    $member = Member::where('profile_id', $senderProfile->id)
        ->currentlyActive()
        ->first();

    if (!$member) {
        return response()->json([
            'success' => false,
            'message' => 'Active membership required',
        ], 403);
    }

    // 🔁 Check if already messaged this receiver
    $alreadyMessaged = Message::where('sender_profile_id', $senderProfile->id)
        ->where('receiver_profile_id', $data['receiver_profile_id'])
        ->exists();

    // ❌ New receiver but limit exhausted
    if (!$alreadyMessaged && $member->messages_sent_remaining <= 0) {
        return response()->json([
            'success' => false,
            'message' => 'Message limit exhausted. Upgrade your plan.',
        ], 403);
    }

    // ✅ Send message
    $message = Message::create([
        'sender_profile_id' => $senderProfile->id,
        'receiver_profile_id' => $data['receiver_profile_id'],
        'message_text' => $data['message_text'],
        'message_type' => $data['message_type'] ?? 'text',
        'is_read' => false,
    ]);

    // 🔻 Decrement ONLY for first-time receiver
    if (!$alreadyMessaged) {
        $member->decrement('messages_sent_remaining');
    }

    return response()->json([
        'success' => true,
        'message' => 'Message sent successfully',
        'remaining_messages' => $member->messages_sent_remaining,
        'data' => $message,
    ]);
}


    /* =====================================================
       POLLING API (INBOX / NEW MESSAGES)
       Used every 3 seconds
    ===================================================== */



    public function getReceiverMessages()
    {
        $user = Auth::user();
        $profile = $user->profile;

        if (!$profile) {
            return response()->json([
                'success' => false,
                'message' => 'Profile not found',
            ], 403);
        }

        $myProfileId = $profile->id;

        // 1️⃣ Get all messages related to me
        $messages = Message::where(function ($q) use ($myProfileId) {
            $q->where('sender_profile_id', $myProfileId)
                ->orWhere('receiver_profile_id', $myProfileId);
        })
            ->orderBy('created_at', 'desc')
            ->get();

        // 2️⃣ Group by conversation (other profile)
        $conversations = $messages
            ->unique(function ($item) use ($myProfileId) {
                return $item->sender_profile_id == $myProfileId
                    ? $item->receiver_profile_id
                    : $item->sender_profile_id;
            })
            ->values()
            ->map(function ($message) use ($myProfileId) {

                // 👤 Find other profile id
                $otherProfileId =
                    $message->sender_profile_id == $myProfileId
                    ? $message->receiver_profile_id
                    : $message->sender_profile_id;

                // 🔗 Profile + User join
                /** @var Profile|null $otherProfile */
                $otherProfile = Profile::with('user:id,name')
                    ->select('id', 'user_id', 'profile_photo', 'gender')
                    ->where('id', $otherProfileId)
                    ->first();

                return [
                    'conversation_with_profile_id' => $otherProfile?->id,

                    // ✅ NAME from users table
                    'name' => $otherProfile?->user?->name,

                    // ✅ PHOTO from profiles table
                    'profile_photo' => $otherProfile
                        ? (
                            $otherProfile->profile_photo
                            ? $otherProfile->profile_photo
                            : (
                                strtolower($otherProfile->gender) === 'female'
                                ? 'storage/default_image/default_female.jpg'
                                : 'storage/default_image/default_male.jpg'
                            )
                        )
                        : null,

                    // 💬 Message preview
                    'last_message' => $message->message_text,
                    'last_message_at' => $message->created_at,
                    'is_read' => $message->is_read,
                ];
            });

        return ApiResponse::success(
            'Conversations fetched successfully',
            $conversations
        );

    }


    /* =====================================================
       CHAT WINDOW (SENDER ↔ RECEIVER)
    ===================================================== */

    public function chatWindowMessages(Request $request)
    {
        $data = $request->validate([
            'receiver_profile_id' => 'required|exists:profiles,id',
        ]);

        $user = Auth::user();
        $senderProfile = $user->profile;

        if (!$senderProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Profile not found',
            ], 403);
        }

        $senderId = $senderProfile->id;
        $receiverId = $data['receiver_profile_id'];

        Message::where('sender_profile_id', $receiverId)
            ->where('receiver_profile_id', $senderId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = Message::where(function ($q) use ($senderId, $receiverId) {
            $q->where('sender_profile_id', $senderId)
                ->where('receiver_profile_id', $receiverId);
        })
            ->orWhere(function ($q) use ($senderId, $receiverId) {
                $q->where('sender_profile_id', $receiverId)
                    ->where('receiver_profile_id', $senderId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        $messages->transform(function ($message) use ($senderId) {
            return [
                'id' => $message->id,
                'sender_profile_id' => $message->sender_profile_id,
                'receiver_profile_id' => $message->receiver_profile_id,
                'message_text' => $message->message_text,
                'message_type' => $message->message_type,
                'is_read' => $message->is_read,
                'created_at' => $message->created_at,
                'updated_at' => $message->updated_at,
                'sender' => $message->sender_profile_id == $senderId,
                'side' => $message->sender_profile_id == $senderId ? 'right' : 'left',
                'time' => $message->created_at->toIso8601String(),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $messages,
        ]);
    }

    public function unreadCount()
    {
        $user = Auth::user();
        $profile = $user?->profile;

        if (!$profile) {
            return ApiResponse::success('Unread message count fetched successfully', ['count' => 0]);
        }

        $count = Message::where('receiver_profile_id', $profile->id)
            ->where('is_read', false)
            ->count();

        return ApiResponse::success('Unread message count fetched successfully', ['count' => $count]);
    }
}