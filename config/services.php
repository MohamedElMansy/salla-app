<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'salla' => [
        'auth_url' => env('SALLA_AUTH_URL', 'https://accounts.salla.sa/oauth2/auth'),
        'token_url' => env('SALLA_TOKEN_URL', 'https://accounts.salla.sa/oauth2/token'),
        'callback_url'=> env('SALLA_CALLBACK_URL','http://127.0.0.1:8000/api/ecommerce/callback'),
        'salla_url'=> env('SALLA_CALLBACK_URL','https://api.salla.dev'),
        'client_id' => env('SALLA_CLIENT_ID', '622d4f16-872c-43c1-aebb-43098804abf4'),
        'client_secret' => env('SALLA_CLIENT_SECRET', '0d6333aee7c28b536741491dedd15bf5'),
    ],

];
