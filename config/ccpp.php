<?php

return [
    'PAYMENT_FINAL_URL' => env('PAYMENT_FINAL_URL'),
    'mode'     => env('CCPP_MODE', 'live'),
    'finalUrl' => env('PAYMENT_FINAL_URL') . '/thank-you',
    'sandbox'  => [
        'baseUrl'           => 'https://sandbox-pgw.2c2p.com/payment/4.3',
        'js_script'         => 'https://demo2.2c2p.com/2C2PFrontEnd/SecurePayment/api/my2c2p-sandbox.1.7.3.min.js',
        'description'       => env('CCPP_PAYMENT_NAME'),
        'MMK'               => [
            'merchant_id' => env('CCPP_MMK_MERCHANT_ID'),
            'secret'      => env('CCPP_MMK_SECRET'),
        ],
        'USD'               => [
            'merchant_id' => env('CCPP_USD_MERCHANT_ID'),
            'secret'      => env('CCPP_USD_SECRET'),
        ],
        'frontendReturnUrl' => env('APP_URL') . '/api/callback/ccpp',
        'backendReturnUrl'  => env('APP_URL') . '/api/webhook/ccpp',
        // 'frontendReturnUrl' => env('APP_URL') . '/callback/ccpp',
        // 'backendReturnUrl'  => env('APP_URL') . '/webhook/ccpp',
    ],
    'live'     => [
        'baseUrl'           => 'https://pgw.2c2p.com/payment/4.1',
        'script'            => 'https://t.2c2p.com/SecurePayment/api/my2c2p.1.7.3.min.js',
        'description'       => env('CCPP_PAYMENT_NAME'),
        'MMK'               => [
            'merchant_id' => env('CCPP_MMK_MERCHANT_ID'),
            'secret'      => env('CCPP_MMK_SECRET'),
        ],
        'USD'               => [
            'merchant_id' => env('CCPP_USD_MERCHANT_ID'),
            'secret'      => env('CCPP_USD_SECRET'),
        ],
        'frontendReturnUrl' => env('APP_URL') . '/api/callback/ccpp',
        'backendReturnUrl'  => env('APP_URL') . '/api/webhook/ccpp',
        // 'frontendReturnUrl' => env('APP_URL') . '/callback/ccpp',
        // 'backendReturnUrl'  => env('APP_URL') . '/webhook/ccpp',
    ],
];
