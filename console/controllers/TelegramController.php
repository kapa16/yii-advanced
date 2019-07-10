<?php

namespace console\controllers;

use common\models\Users;
use console\components\TelegramCommands;
use Exception;
use SonkoDmitry\Yii\TelegramBot\Component;
use tasktracker\entities\telegram\TelegramOffset;
use TelegramBot\Api\Types\Message;
use TelegramBot\Api\Types\Update;
use yii\console\Controller;

class TelegramController extends Controller
{
    /** @var $bot Component */
    private $bot;
    private $users;
    private $telegram;
    private $offset = 0;

    public function __construct($id, $module, TelegramCommands $telegram, Users $users, Component $bot, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->bot = $bot;
        $this->telegram = $telegram;
        $this->users = $users;
    }

    public function actionIndex()
    {
        $updates = $this->bot->getUpdates($this->getOffset() + 1);
        $updCount = count($updates);
        if (!$updCount) {
            echo "Новых сообщений нет" . PHP_EOL;
            return;
        }

        echo "Новых сообщений " . $updCount . PHP_EOL;
        foreach ($updates as $update) {
            $message = $update->getMessage();
            $telegramId = $message->getFrom()->getId();
            $this->updateOffset($update);

            if (!$user = $this->users::findByTelegramId($telegramId)) {
                if (!$user = $this->users::findByUsername($message->getText())) {
                    $this->bot->sendMessage($telegramId, 'Enter your username on task-tracker');
                    continue;
                }
                $user->telegram_id = $telegramId;
                $user->save();
            }
            $this->processCommand($message, $user);
        }
    }

    private function getOffset()
    {
        $this->offset = TelegramOffset::find()
            ->select('id')
            ->max('id');

        return $this->offset;
    }

    private function updateOffset(Update $update)
    {
        $model = new TelegramOffset([
            'id' => $update->getUpdateId(),
            'timestamp_offset' => date("Y-m-d H:i:s")
        ]);
        $model->save();
    }

    private function processCommand(Message $message, Users $user)
    {
        $params = explode(' ', $message->getText());
        $command = $params[0];
        try {
            $response = $this->telegram->execute($command, $params, $message, $user);
        } catch (Exception $e) {
            $response = $e->getMessage();
        }
        $this->bot->sendMessage($message->getFrom()->getId(), $response);
    }

}