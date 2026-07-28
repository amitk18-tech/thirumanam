<?php

namespace Bits\Package\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsGatewayHubService
{
    public function send(string $mobile, string $templateId, array $variables)
    {
        $payload = [
            'APIKey'        => config('sms.gateway.apikey'),
            'senderid'      => config('sms.gateway.sender'),
            'channel'       => 2,
            'DCS'           => 0,
            'flashsms'      => 0,
            'number'        => $mobile,
            'route'         => config('sms.gateway.route'),
            'text'          => $variables['text'] ?? '',
            'EntityId'      => config('sms.gateway.entity_id'),
            'dlttemplateid' => $templateId,
        ];

        // attach var1, var2...
        foreach ($variables as $key => $value) {
            if (str_starts_with($key, 'var')) {
                $payload[$key] = $value;
            }
        }

        $response = Http::get(config('sms.gateway.url'), $payload);

        Log::info('SMS Gateway Request', $payload);
        Log::info('SMS Gateway Response', [
            'status' => $response->status(),
            'body'   => $response->body(),
        ]);

        return $response->json();
    }
}
