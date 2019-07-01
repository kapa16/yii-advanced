<?php

namespace console\controllers;

use console\components\WsComments;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use yii\console\Controller;

class WsServerController extends Controller
{
    public function actionStart(): void
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    \Yii::$container->get(WsComments::class)
                )
            ), 8080
        );
        echo 'Server start on port 8080 ...' . PHP_EOL;
        $server->run();
    }
}