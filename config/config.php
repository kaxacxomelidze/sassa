<?php
return [
    'app' => [
        'name' => 'Sassa Support',
        'url' => 'http://localhost/sassa',
        'timezone' => 'UTC',
        'default_language' => 'en',
        'session_name' => 'sassa_session',
        'key' => 'base64:CHANGE_ME_WITH_RANDOM_32BYTE_BASE64',
    ],
    'db' => [
        'host' => '127.0.0.1',
        'port' => 3306,
        'name' => 'sassa_support',
        'user' => 'root',
        'pass' => '',
        'charset' => 'utf8mb4',
    ],
    'security' => [
        'csrf_token_name' => '_csrf',
        'session_regenerate_interval' => 300,
    ],
];
