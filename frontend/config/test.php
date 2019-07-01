<?php

$urlManager = require __DIR__ . '/url-manager.php';

return [
    'id' => 'app-frontend-tests',
    'components' => [
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'urlManager' => $urlManager,
        'request' => [
            'cookieValidationKey' => 'test',
        ],
    ],
];
