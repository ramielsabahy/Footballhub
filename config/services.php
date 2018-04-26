<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    // 'facebook' => [
    //     'client_id' => '364976253927530',
    //     'client_secret' => 'ffb3e4805775428e57b201c1c1b306a4',
    //     'redirect' => 'http://footballHub.laravel.com/login/facebook/callback',
    // ],

    // 'google' => [
    //     'client_id' => '660614342805-bap3fjt7r9a1mht33eu8ahsgs3p2mpga.apps.googleusercontent.com',
    //     'client_secret' => 'gSMRHIQsZhyDU_M3mtTFg3SC',
    //     'redirect' => 'http://footballHub.laravel.com/login/google/callback',
    // ],
];
