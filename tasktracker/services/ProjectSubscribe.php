<?php


namespace tasktracker\services;


use tasktracker\entities\telegram\TelegramSubscribe;

class ProjectSubscribe
{
    private $bot;

    public function __construct()
    {
        $this->bot = \Yii::$app->bot;
    }

    private function SendCreateHandler($target)
    {
        $subscriptions =  TelegramSubscribe::find()
            ->where(['target' => $target])
            ->all();

        $message = "Create new project: ";

        foreach ($subscriptions as $message => $recipients) {
            foreach ($recipients as $recipient) {
                $this->bot->sendMessage($recipient->telegram_id, $message);
            }
        }
    }
}