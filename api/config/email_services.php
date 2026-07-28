<?php

return [
    'password_reset' => [
        'driver' => 'smtp',
        'host' => env('EMAIL_SERVER_PASSWORD_RESET_HOST', 'smtp.server1.com'),
        'port' => env('EMAIL_SERVER_PASSWORD_RESET_PORT', 587),
        'username' => env('EMAIL_SERVER_PASSWORD_RESET_USERNAME', 'passwordreset@xyz.com'),
        'password' => env('EMAIL_SERVER_PASSWORD_RESET_PASSWORD', 'password'),
        'encryption' => env('EMAIL_SERVER_PASSWORD_RESET_ENCRYPTION', 'tls'),
        'from' => [
            'address' => env('EMAIL_SERVER_PASSWORD_RESET_FROM_ADDRESS', 'passwordreset@xyz.com'),
            'name' => env('EMAIL_SERVER_PASSWORD_RESET_FROM_NAME', 'YourApp Password Reset'),
        ],
    ],


    'verification' => [
        'driver' => 'smtp',
        'host' => env('EMAIL_SERVER_PASSWORD_RESET_HOST', 'smtp.hostinger.com'),
        'port' => env('EMAIL_SERVER_PASSWORD_RESET_PORT', 587),
        'username' => env('EMAIL_SERVER_PASSWORD_RESET_USERNAME', 'verify@mayiladuthuraiproperties.com'),
        'password' => env('EMAIL_SERVER_PASSWORD_RESET_PASSWORD', 'JKblksjduif!sdf1'),
        'encryption' => env('EMAIL_SERVER_PASSWORD_RESET_ENCRYPTION', 'tls'),
        'from' => [
            'address' => env('EMAIL_SERVER_PASSWORD_RESET_FROM_ADDRESS', 'verify@mayiladuthuraiproperties.com'),
            'name' => env('EMAIL_SERVER_PASSWORD_RESET_FROM_NAME', 'Password verfiy'),
        ],
    ],

    'newsletter' => [
        'driver' => 'smtp',
        'host' => env('EMAIL_SERVER_NEWSLETTER_HOST', 'smtp.server1.com'),
        'port' => env('EMAIL_SERVER_NEWSLETTER_PORT', 587),
        'username' => env('EMAIL_SERVER_NEWSLETTER_USERNAME', 'newsletter@xyz.com'),
        'password' => env('EMAIL_SERVER_NEWSLETTER_PASSWORD', 'password'),
        'encryption' => env('EMAIL_SERVER_NEWSLETTER_ENCRYPTION', 'tls'),
        'from' => [
            'address' => env('EMAIL_SERVER_NEWSLETTER_FROM_ADDRESS', 'newsletter@xyz.com'),
            'name' => env('EMAIL_SERVER_NEWSLETTER_FROM_NAME', 'YourApp Newsletter'),
        ],
    ],

    // Add more email configurations as needed
];
