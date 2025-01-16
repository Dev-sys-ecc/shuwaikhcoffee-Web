<?php

declare(strict_types=1);

return [
    'sendchamp' => [
        'timeout' => 15,

        'mode' => env('SENDCHAMP_MODE', 'sandbox'),

        'public_key' => env('SENDCHAMP_PUBLIC_KEY', ''),

        'sandbox_url' => env(
            'SENDCHAMP_SANDBOX_URL',
            'https://sandbox-api.sendchamp.com/api/v1'
        ),

        'live_url' => env('SENDCHAMP_LIVE_URL', 'https://api.sendchamp.com/api/v1')
    ]
];
