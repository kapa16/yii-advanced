<?php

namespace tasktracker\notification;

use SonkoDmitry\Yii\TelegramBot\Component;
use tasktracker\entities\telegram\TelegramSubscribe;

class TelegramNotification
{
    private $bot;

    public function __construct(Component $bot)
    {
        $this->bot = $bot;
    }

    public function send($message, $target): void
    {
        $subscriptions =  TelegramSubscribe::findAll(['target' => $target]);

        foreach ($subscriptions as $recipient) {
            $this->bot->sendMessage($recipient->telegram_id, $message);
        }

    }
}