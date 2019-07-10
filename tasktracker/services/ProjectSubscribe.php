<?php

namespace tasktracker\services;

use tasktracker\entities\project\Projects;
use tasktracker\notification\TelegramNotification;

class ProjectSubscribe
{
    private $telegram;

    public function __construct(TelegramNotification $telegram)
    {
        $this->telegram = $telegram;
    }

    public function sendCreateHandler($target, Projects $project): void
    {
        $message = "Create new project: {$project->name}";

        $this->telegram->send($message, $target);
    }
}