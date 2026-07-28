<?php
namespace Bits\Shipping\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ShiprocketService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.shiprocket.base_url');
    }

    public function token(): string
    {
        return Cache::remember('shiprocket_token', now()->addHours(8), function () {
            $response = Http::post($this->baseUrl . '/auth/login', [
                'email'    => config('services.shiprocket.email'),
                'password' => config('services.shiprocket.password'),
            ]);

            if (!$response->successful()) {
                throw new \Exception('Shiprocket login failed');
            }

            return $response['token'];
        });
    }

    public function createOrder(array $payload): array
    {
        $response = Http::withToken($this->token())
            ->post($this->baseUrl . '/orders/create/adhoc', $payload);

        if (!$response->successful()) {
            throw new \Exception(
                'Shiprocket Error: ' . ($response->json()['message'] ?? $response->body())
            );
        }

        return $response->json();
    }

    public function track(string $awb): array
    {
        return Http::withToken($this->token())
            ->get($this->baseUrl . "/courier/track/awb/{$awb}")
            ->json();
    }
}