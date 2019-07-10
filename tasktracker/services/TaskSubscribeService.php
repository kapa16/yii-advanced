<?php

namespace tasktracker\services;

use common\models\Users;
use tasktracker\entities\task\Tasks;
use tasktracker\notification\TelegramNotification;
use yii\mail\MailerInterface;

class TaskSubscribeService
{
    private $senderEmail;
    private $mailer;
    private $telegram;
    private $task;
    private $subject;
    private $template;

    public function __construct($senderEmail, MailerInterface $mailer, TelegramNotification $telegram)
    {
        $this->senderEmail = $senderEmail;
        $this->mailer = $mailer;
        $this->telegram = $telegram;
    }

    public function sendCreateHandler($target, Tasks $task): void
    {
        $this->task = $task;

        $this->sendCreateMail();

        $message = "Create new task: {$task->name}";
        $this->telegram->send($message, $target);
    }

    private function sendCreateMail(): void
    {
        $this->subject = 'New task';
        $this->template = 'createNotification-html';
        $this->sendNotification($this->task->responsible);
    }

    public function sendDeadline($tasks): void
    {
        $this->task = $tasks;
        $this->subject = 'Deadline';
        $this->template = 'deadlineNotification-html';
        $this->sendNotification($this->task->responsible);
    }

    private function sendNotification(Users $user): void
    {
        $this->mailer->compose(
            ['html' => 'task/' . $this->template],
            [
                'user' => $user,
                'task' => $this->task,
            ])
            ->setTo($user->email)
            ->setFrom($this->senderEmail)
            ->setSubject($this->subject)
            ->send();
    }
}