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

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'sms' => [
        // semaphore = SMS gateway (kailangan ng approved sender name)
        // android   = Android phone na may SIM (walang sender name na kailangan)
        'driver'  => env('SMS_DRIVER', 'semaphore'),
        'enabled' => env('SMS_ENABLED', true),
    ],

    'semaphore' => [
        'key'         => env('SEMAPHORE_API_KEY'),
        'sender_name' => env('SEMAPHORE_SENDER_NAME', 'DENTAEASE'),
        'timeout'     => env('SEMAPHORE_TIMEOUT', 10),
    ],

    'android_sms' => [
        'url'      => env('ANDROID_SMS_URL'),       // hal. http://192.168.1.5:8080
        'username' => env('ANDROID_SMS_USERNAME'),
        'password' => env('ANDROID_SMS_PASSWORD'),
        'timeout'  => env('ANDROID_SMS_TIMEOUT', 15),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
