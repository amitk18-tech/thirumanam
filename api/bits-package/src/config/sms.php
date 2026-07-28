<?php
return [
    'gateway' => [
        'url'       => 'https://www.smsgatewayhub.com/api/mt/SendSMS',
        'apikey'    => env('SMSGHUB_API_KEY'),
        'sender'    => env('SMSGHUB_SENDER_ID'),
        'entity_id' => env('SMSGHUB_ENTITY_ID'),
        'route'     => env('SMSGHUB_ROUTE', 1),
    ],
    'templates' => [
        'otp'                => env('SMS_TEMPLATE_OTP'),
        'renewal'            => env('SMS_TEMPLATE_RENEWAL'),
        'account_activation' => env('SMS_TEMPLATE_ACCOUNT_ACTIVATION'),
    ],
];
