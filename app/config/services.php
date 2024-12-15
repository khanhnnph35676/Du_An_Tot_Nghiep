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
    // 'vnpay' => [
    //     'vnp_TmnCode' => env('VNPAY_TMN_CODE', 'PE0TTJQA'),  // Terminal ID / Mã website
    //     'vnp_HashSecret' => env('VNPAY_HASH_SECRET', 'F3AS7O1Z9ICD3RCULK6UKI21VMPX2WDK'),  // Secret key
    //     'vnp_Url' => env('VNPAY_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html'),  // URL thanh toán môi trường TEST
    //     'vnp_ReturnUrl' => env('VNPAY_RETURN_URL', 'http://127.0.0.1:8000/success-checkout'),  // URL người dùng quay lại sau khi thanh toán,
    //     'timer' => env('VNPAY_TIMER', 30000),
    // ],


];
