<?php

return [
    'url' => env('FRONTEND_URL', 'http://localhost:4200'),
    'email_verification_url' => env('FRONTEND_EMAIL_VERIFICATION_URL', 'http://localhost:4200/email/verify'),
    'password_reset_url' => env('FRONTEND_PASSWORD_RESET_URL', 'http://localhost:4200/password/reset'),
    'google_auth_callback_url' => env('FRONTEND_GOOGLE_AUTH_CALLBACK', 'http://localhost:4200/auth/callback'),
];

