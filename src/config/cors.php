<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    // IMPORTANTE: aquí NO puede ir '*'
    'allowed_origins' => [
        'http://127.0.0.1:5173',
        'http://localhost:5173',
    ],

    'allowed_origins_patterns' => [],

    // Necesario para enviar cookies HTTP-Only
    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    // Necesario para credentials: "include"
    'supports_credentials' => true,

];
