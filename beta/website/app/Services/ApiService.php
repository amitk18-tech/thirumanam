<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class ApiService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.api.base_url'), '/') . '/';
    }

    /**
     * Get auth headers for authenticated requests
     */
    protected function authHeaders(): array
    {
        $token = Session::get('api_token');
        return [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ];
    }

    /**
     * GET request — public (no auth)
     */
    public function get(string $endpoint, array $params = []): array
    {
        try {
            $response = Http::withHeaders(['Accept' => 'application/json'])
                ->get($this->baseUrl . ltrim($endpoint, '/'), $params);
            return $response->json() ?? [];
        } catch (\Throwable $e) {
            Log::error('API GET failed', ['endpoint' => $endpoint, 'error' => $e->getMessage()]);
            return [];
        }
    }

    /**
     * GET request — authenticated
     */
    public function authGet(string $endpoint, array $params = []): array
    {
        try {
            $response = Http::withHeaders($this->authHeaders())
                ->get($this->baseUrl . ltrim($endpoint, '/'), $params);
            return $response->json() ?? [];
        } catch (\Throwable $e) {
            Log::error('API AUTH GET failed', ['endpoint' => $endpoint, 'error' => $e->getMessage()]);
            return [];
        }
    }

    /**
     * POST request — public (no auth)
     */
    public function post(string $endpoint, array $data = []): array
    {
        try {
            $response = Http::withHeaders(['Accept' => 'application/json'])
                ->asJson()->post($this->baseUrl . ltrim($endpoint, '/'), $data);
            return $response->json() ?? [];
        } catch (\Throwable $e) {
            Log::error('API POST failed', ['endpoint' => $endpoint, 'error' => $e->getMessage()]);
            return [];
        }
    }

    /**
     * POST request — authenticated
     */
    public function authPost(string $endpoint, array $data = []): array
    {
        try {
            $response = Http::withHeaders($this->authHeaders())
                ->asJson()->post($this->baseUrl . ltrim($endpoint, '/'), $data);
            return $response->json() ?? [];
        } catch (\Throwable $e) {
            Log::error('API AUTH POST failed', ['endpoint' => $endpoint, 'error' => $e->getMessage()]);
            return [];
        }
    }

    /**
     * POST with multipart (file uploads)
     */
    public function authPostMultipart(string $endpoint, array $data = [], array $files = []): array
    {
        try {
            $request = Http::withHeaders($this->authHeaders())->asMultipart();

            foreach ($data as $key => $value) {
             $request = $request->attach($key, (string)$value, null, ['Content-Type' => 'text/plain']);
                }

            foreach ($files as $key => $fileOrArray) {
                $fileList = is_array($fileOrArray) ? $fileOrArray : [$fileOrArray];
                foreach ($fileList as $file) {
                    $request = $request->attach($key . '[]', file_get_contents($file->getRealPath()), $file->getClientOriginalName());
                }
            }

            $response = $request->post($this->baseUrl . ltrim($endpoint, '/'));
            return $response->json() ?? [];
        } catch (\Throwable $e) {
            Log::error('API MULTIPART POST failed', ['endpoint' => $endpoint, 'error' => $e->getMessage()]);
            return [];
        }
    }

    // ─── SPECIFIC METHODS ───────────────────────────────────────────

    public function getHomePageData(): array
    {
        return $this->authGet('/home-page-data');
    }

    public function login(string $phone, string $password): array
    {
        return $this->post('/auth/user/login', compact('phone', 'password'));
    }

    public function sendOtp(string $mobile, string $gender = ''): array
    {
        $payload = ['mobile' => $mobile, 'type' => 'first_time_login'];
        if ($gender) $payload['gender'] = $gender;
        return $this->post('/send-sms', $payload);
    }

    public function verifyOtp(string $mobile, string $otp): array
    {
        return $this->post('/verify-sms', ['mobile' => $mobile, 'otp' => $otp, 'type' => 'first_time_login']);
    }

    public function getMembers(array $params = []): array
    {
        return $this->authGet('/members', $params);
    }

    public function getMember(int $id): array
    {
        return $this->authGet("/members/{$id}");
    }

    public function getFullProfile(int $id): array
    {
        return $this->authGet("/members/full-profile/{$id}");
    }

    public function getMyProfile(): array
    {
        return $this->authGet('/browse-members/me');
    }

    public function getNotificationsCount(): array
    {
        return $this->authGet('/notifications/count');
    }

    public function getNotifications(): array
    {
        return $this->authGet('/notifications');
    }

    public function getMemberships(): array
    {
        return $this->authGet('/membership');
    }

    public function sendInterest(int $receiverId): array
    {
        return $this->authPost("/match-action/{$receiverId}/interest");
    }

    public function shortlistMember(int $receiverId): array
    {
        return $this->authPost("/match-action/{$receiverId}/shortlist");
    }

    public function consumeProfileView(int $profileId): array
    {
        return $this->authPost('/interaction/consume-view', ['profile_id' => $profileId]);
    }

    public function getMessages(): array
    {
        return $this->authGet('/message/get-message');
    }

    public function getUnreadCount(): array
    {
        return $this->authGet('/message/unread-count');
    }

    public function sendMessage(int $receiverProfileId, string $message): array
    {
        return $this->authPost('/message/send-message', [
            'receiver_profile_id' => $receiverProfileId,
            'message_text' => $message,
        ]);
    }

    public function getChatWindow(int $receiverProfileId): array
    {
        return $this->authPost('/message/chat-window', ['receiver_profile_id' => $receiverProfileId]);
    }
    
    public function uploadProfilePhoto(string $profileId, \Illuminate\Http\UploadedFile $file): array
    {
        try {
            $fileContents = file_get_contents($file->getRealPath());
            $fileName = $file->getClientOriginalName();

            // 1. Upload to photos gallery
            $photoResponse = Http::withHeaders($this->authHeaders())
                ->asMultipart()
                ->attach('profile_id', $profileId, null, ['Content-Type' => 'text/plain'])
                ->attach('is_primary', '1', null, ['Content-Type' => 'text/plain'])
                ->attach('photo_url[]', $fileContents, $fileName)
                ->post($this->baseUrl . 'photo');

            $result = $photoResponse->json() ?? [];

            if ($result['success'] ?? false) {
                // 2. Update profile_photo field on profile
                Http::withHeaders($this->authHeaders())
                    ->asMultipart()
                    ->attach('profile_photo', $fileContents, $fileName)
                    ->post($this->baseUrl . "profile/{$profileId}");
            }

            return $result;
        } catch (\Throwable $e) {
            Log::error('uploadProfilePhoto failed', ['error' => $e->getMessage()]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
