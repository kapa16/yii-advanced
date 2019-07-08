<?php

use common\components\Bootstrap;
use yii\i18n\PhpMessageSource;

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
    ],
];
