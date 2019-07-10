<?php

namespace console\controllers;

use tasktracker\repositories\TaskRepository;
use tasktracker\services\TaskSubscribeService;
use DateInterval;
use DateTime;
use yii\console\Controller;

class TaskController extends Controller
{
    private $tasks;
    private $subscribe;

    public function __construct($id, $module, TaskRepository $tasks, TaskSubscribeService $subscribe, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->tasks = $tasks;
        $this->subscribe = $subscribe;
    }


    public function actionCheckDeadline($daysLeft = 1): void
    {
        $from = new DateTime();
        $to = new DateTime('tomorrow');
        $interval = new DateInterval('P' . $daysLeft . 'D');
        $tasks = $this->tasks->findIncompleteByDeadline($from, $to->add($interval));

        foreach ($tasks as $task) {
            $this->subscribe->sendDeadline($task, $daysLeft);
        }
    }
}