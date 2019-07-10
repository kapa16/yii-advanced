<?php

namespace common\components;

use console\components\TelegramCommands;
use console\components\WsComments;
use tasktracker\entities\project\Projects;
use tasktracker\entities\task\Tasks;
use tasktracker\services\ProjectSubscribe;
use tasktracker\services\TaskSubscribeService;
use Yii;
use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\mail\MailerInterface;

class Bootstrap implements BootstrapInterface
{

    public function bootstrap($app)
    {
        $container = Yii::$container;

        $container->setSingleton(MailerInterface::class, static function () use ($app) {
            return $app->mailer;
        });

        $container->setSingleton(TaskSubscribeService::class, [], [
            $app->params['senderEmail']
        ]);

        $container->setSingleton(WsComments::class);

        $container->setSingleton(ProjectSubscribe::class);

        Event::on(
            Tasks::class,
            Tasks::EVENT_AFTER_INSERT,
            function ($event) {
                Yii::warning($event);
                exit;
            }
//            [$container->get(TaskSubscribeService::class), 'SendCreateHandler']
        );

        Event::on(
            Projects::class,
            Projects::EVENT_AFTER_INSERT,
            function ($event) use ($container) {
                var_dump($event);
                exit;
                Yii::warning('начало вычисления среднего дохода');
                $container->get(
                    TaskSubscribeService::class)
                    ->SendCreateHandler(TelegramCommands::SUBSCRIBE_PROJECT_CREATE, $event->sender);
            }
        );

    }
}