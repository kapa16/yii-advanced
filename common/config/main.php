<?php

use common\components\Bootstrap;
use SonkoDmitry\Yii\TelegramBot\Component;
use yii\i18n\PhpMessageSource;

$params = array_merge(
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'bootstrap' => ['bootstrap'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(__DIR__, 2) . '/vendor',
    'components' => [
        'bootstrap' => [
            'class' => Bootstrap::class
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => PhpMessageSource::class,
                ]
            ]
        ],
        'bot' => [
            'class' => Component::class,
            'apiToken' => $params['telegramToken'],
        ],
    ],
];
