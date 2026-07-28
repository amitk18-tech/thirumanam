<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;

class MessageController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        $response = $this->api->getMessages();
        $conversations = $response['data'] ?? [];
        $baseUrl = rtrim(config('services.api.base_url'), '/api/');
        $baseUrl = str_replace('/api', '', $baseUrl);

        foreach ($conversations as &$conv) {
            $photo = $conv['profile_photo'] ?? '';
            if ($photo && !str_starts_with($photo, 'http')) {
                $conv['profile_photo'] = rtrim($baseUrl, '/') . '/' . ltrim($photo, '/');
            }
        }
        unset($conv);

        return view('messages.index', compact('conversations'));
    }

    public function chatWindow(Request $request)
    {
        $receiverProfileId = $request->input('receiver_profile_id');
        $response = $this->api->getChatWindow((int) $receiverProfileId);
        $messages = $response['data'] ?? [];
        return response()->json(['success' => true, 'data' => $messages]);
    }

    public function send(Request $request)
    {
        $request->validate([
            'receiver_profile_id' => 'required|integer',
            'message_text' => 'required|string|max:1000',
        ]);

        $response = $this->api->sendMessage(
            (int) $request->input('receiver_profile_id'),
            $request->input('message_text')
        );

        return response()->json($response);
    }

    public function unreadCount()
    {
        $response = $this->api->getUnreadCount();
        $count = $response['data']['count'] ?? 0;
        return response()->json(['count' => $count]);
    }
}
