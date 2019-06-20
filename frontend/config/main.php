<?php

use common\components\BootstrapWeb;
use common\models\Users;
use yii\web\Session;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'bootstrap'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'bootstrap' => [
            'class' => BootstrapWeb::class
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'cookieValidationKey' => $params['cookieValidationKey'],
        ],
        'user' => [
            'identityClass' => Users::class,
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity',
                'httpOnly' => true,
                'domain' => $params['cookieDomain'],
            ],
        ],
        'session' => [
            'class' => Session::class,
            // this is the name of the session cookie used for login on the frontend
            'name' => '_session',
            'cookieParams' => [
                'httponly' => true,
                'domain' => $params['cookieDomain'],
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'site/index',
                '<action:(about|contact|login)>' => 'site/<action>',
                '<controller>/page/<page:\d+>/per-page/<per-page:\d+>' => '<controller>/index',
                '<controller>' => '<controller>/index',
                '<controller>/<id:\d+>' => '<controller>/view',
                '<controller>/<id:\d+>/<action>' => '<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];
