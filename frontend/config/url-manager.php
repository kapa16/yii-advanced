<?php

use yii\rest\UrlRule;

return [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        ['class' => UrlRule::class, 'controller' => 'v1/task'],
        '/' => 'project/index',
        '<action:(about|contact|login)>' => 'site/<action>',
        '<controller>/project/<project_id:\d+>' => '<controller>/project',
        '<controller>/page/<page:\d+>/per-page/<per-page:\d+>' => '<controller>/index',
        '<controller>' => '<controller>/index',
        '<controller>/<id:\d+>' => '<controller>/view',
        '<controller>/<id:\d+>/<action>' => '<controller>/<action>',
    ],
];