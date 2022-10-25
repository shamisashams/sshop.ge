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
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'facebook' => [
        'client_id' => '1250269695555740',
        'client_secret' => '1720f94cc87fb3c93f2c562b5dddb476',
        'redirect' => 'https://sshop.ge/ge/auth/facebook/callback',
    ],
    'google' => [
        'client_id' => '194477847906-5oba7obd2csbm6bn3a6u2jb22usln98o.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'https://sshop.ge/ge/auth/google/callback',
    ],

];
