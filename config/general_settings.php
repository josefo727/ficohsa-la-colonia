<?php

return [
    'encryption' => [
        'enabled' => true,
        'key' => env('GENERAL_SETTINGS_ENCRYPTION_KEY', 'some_default_key'),
    ],
    'show_passwords' => env('GENERAL_SETTINGS_SHOW_PASSWORDS', false),
    'crud_web' => [
        'enable' => true,
        'middleware' => \App\Http\Middleware\Authenticate::class,
        // 'middleware' => \Josefo727\GeneralSettings\Http\Middleware\TestWebMiddleware::class
    ],
    'crud_api' => [
        'enable' => false,
        'middleware' => \App\Http\Middleware\Authenticate::class,
        // 'middleware' => \Josefo727\GeneralSettings\Http\Middleware\TestApiMiddleware::class
    ]
];
