<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=task_tracker',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
    ],
];
