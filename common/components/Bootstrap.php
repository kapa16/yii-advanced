<?php

namespace common\components;

use console\components\TelegramCommands;
use console\components\WsComments;
use SonkoDmitry\Yii\TelegramBot\Component;
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

         $container->setSingleton(Component::class, static function () use ($app) {
             $bot = new Component(['apiToken' => $app->params['telegramToken']]);
             $bot->setCurlOption(CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
             $bot->setCurlOption(CURLOPT_PROXY, $app->params['proxyServer']);
             $bot->setCurlOption(CURLOPT_PROXYUSERPWD, $app->params['proxyAuth']);

            return $bot;
        });

        $container->setSingleton(TaskSubscribeService::class, [], [
            $app->params['senderEmail']
        ]);

        $container->setSingleton(WsComments::class);

        $container->setSingleton(ProjectSubscribe::class);

        Event::on(
            Tasks::class,
            Tasks::EVENT_AFTER_INSERT,
            function ($event) use ($container) {
                $container->get(TaskSubscribeService::class)
                    ->sendCreateHandler(TelegramCommands::SUBSCRIBE_TASK_CREATE, $event->sender);
            }
        );

        Event::on(
            Projects::class,
            Projects::EVENT_AFTER_INSERT,
            function ($event) use ($container) {
                $container->get(ProjectSubscribe::class)
                    ->sendCreateHandler(TelegramCommands::SUBSCRIBE_PROJECT_CREATE, $event->sender);
            }
        );

    }
}