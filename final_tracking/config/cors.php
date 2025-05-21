<?php

return [
    'paths' => ['api/*', '/pc-login', '/pc-logout'],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['*'], // You can restrict this in production

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
];

