<?php

namespace console\components;

use common\models\Users;
use tasktracker\entities\project\Projects;
use tasktracker\entities\telegram\TelegramSubscribe;
use TelegramBot\Api\Types\Message;
use yii\base\InvalidValueException;

class TelegramCommands
{
    public const SUBSCRIBE_PROJECT_CREATE = '/subscribe_project_create';
    public const SUBSCRIBE_TASK_CREATE = '/subscribe_task_create';

    /** @var Message */
    private $message;
    /** @var Users */
    private $user;
    private $subscriptions = [];

    public function execute($command, $params, Message $message, Users $user)
    {
        if (strpos($command, '/') !== 0) {
            return $this->help();
        }
        $method = str_replace('/', '', $command);
        $method = preg_replace_callback('/_([a-zA-Z]+)/', function ($matches) {
            return ucwords($matches[1]);
        }, $method);
        if (!method_exists(static::class, $method)) {
            return $this->help();
        }

        $this->message = $message;
        $this->user = $user;
        return $this->$method($params);
    }

    private function help($params = [])
    {
        $response = "Доступные команды: \n";
        $response .= "/help - список комманд\n";
        $response .= "/project_create ##project_name## -создание нового проекта\n";
        $response .= "/task_create ##task_name## ##responcible## ##project## -созданпие таска\n";
        $response .= self::SUBSCRIBE_PROJECT_CREATE . " - подписка на создание проекта\n";
        $response .= self::SUBSCRIBE_TASK_CREATE . " - подписка на создание задачи\n";
        return $response;
    }

    private function projectCreate($params)
    {
        $projectName = $params[1] ?? null;
        if (!$projectName) {
            throw new InvalidValueException('Missing parameter ##project_name##');
        }
        $projectName = str_replace('_', ' ', $projectName);

        $project = Projects::create($projectName, $this->user->id);
        if (!$project->save()) {
            return 'Error creating project';
        }
        $this->setSubscriptions(self::SUBSCRIBE_PROJECT_CREATE, "Create new project: {$projectName}");
        return 'Project created successfully';
    }

    private function subscribeProjectCreate($params)
    {
        return $this->createSubscribe(self::SUBSCRIBE_PROJECT_CREATE);
    }

    private function subscribeTaskCreate($params)
    {
        return $this->createSubscribe(self::SUBSCRIBE_TASK_CREATE);
    }

    private function createSubscribe($target)
    {
        $subscribe = TelegramSubscribe::create(
            $this->message->getFrom()->getId(),
            $target
        );
        if (!$subscribe->save()) {
            return 'Error creating subscribe';
        }
        return 'Subscribe created successfully';
    }

    public function getSubscriptions()
    {
        return $this->subscriptions;
    }

}