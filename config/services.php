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
    'public' => env('STRIPE_KEY'),
    'secret' => env('STRIPE_SECRET'),
],

'recaptcha' => [
    'sitekey' => env('6LfKmJEqAAAAANXLIy4co_Chwd9L0gbEAHjfNMCp'),
    'secret'  => env('6LfKmJEqAAAAAFEWaNJuyM5t_1vOpD3j72V150L6'),
],


];
