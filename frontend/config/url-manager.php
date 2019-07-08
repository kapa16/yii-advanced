<?php
return [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        '/' => 'project/index',
        '<action:(about|contact|login)>' => 'site/<action>',
        '<controller>/project/<project_id:\d+>' => '<controller>/project',
        '<controller>/page/<page:\d+>/per-page/<per-page:\d+>' => '<controller>/index',
        '<controller>' => '<controller>/index',
        '<controller>/<id:\d+>' => '<controller>/view',
        '<controller>/<id:\d+>/<action>' => '<controller>/<action>',
    ],
];