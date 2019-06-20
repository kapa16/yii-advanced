<?php

namespace tasktracker\services;

use common\models\Users;
use tasktracker\entities\task\Tasks;
use yii\mail\MailerInterface;

class TaskSubscribeService
{
    private $senderEmail;
    private $mailer;
    private $task;
    private $subject;
    private $template;

    public function __construct($senderEmail, MailerInterface $mailer)
    {
        $this->senderEmail = $senderEmail;
        $this->mailer = $mailer;
    }

    public function SendCreateHandler($event): void
    {
        /** @var Tasks $eventSender */
        $this->task = $event->sender;
        if (!is_a($this->task, Tasks::class)) {
            throw new \UnexpectedValueException ('Invalid event sender type');
        }

        $this->subject = 'New task';
        $this->template = 'createNotification-html';
        $this->SendNotification($this->task->responsible);
    }

    private function SendNotification(Users $user): void
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

    public function SendDeadline($tasks): void
    {
        $this->task = $tasks;
        $this->subject = 'Deadline';
        $this->template = 'deadlineNotification-html';
        $this->SendNotification($this->task->responsible);
    }
}