<?php

namespace tasktracker\services;

use tasktracker\entities\project\Projects;
use tasktracker\entities\task\Comments;
use tasktracker\entities\task\Tasks;
use tasktracker\forms\task\TaskForm;
use tasktracker\repositories\StatusRepository;
use tasktracker\repositories\TaskRepository;
use tasktracker\repositories\UserRepository;
use Faker\Factory;
use yii\caching\DbDependency;

class TaskService
{
    private $tasks;
    private $statuses;
    private $users;
    private $projects;

    /**
     * TaskService constructor.
     * @param TaskRepository $tasks
     * @param StatusRepository $statuses
     * @param UserRepository $users
     * @param Projects $projects
     */
    public function __construct(
        TaskRepository $tasks,
        StatusRepository $statuses,
        UserRepository $users,
        Projects $projects
    )
    {
        $this->tasks = $tasks;
        $this->statuses = $statuses;
        $this->users = $users;
        $this->projects = $projects;
    }

    public function create(TaskForm $form): Tasks
    {
        $responsible = $this->users->get($form->responsible);
        $status = $this->statuses->get($form->status);
        $project = $this->projects::findOne($form->project);

        $task = Tasks::create(
            $form->name,
            $form->description,
            $status->id,
            $responsible->id,
            date('Y.m.d',strtotime($form->deadline)),
            $project->id
        );
        $this->tasks->save($task);
        return $task;
    }

    public function edit($d, TaskForm $form): Tasks
    {
        $task = $this->tasks->get($d);
        $responsible = $this->users->get($form->responsible);
        $status = $this->statuses->get($form->status);
        $project = $this->projects::findOne($form->project);

        $task->edit(
            $form->name,
            $form->description,
            $status->id,
            $responsible->id,
            date('Y.m.d',strtotime($form->deadline)),
            $project->id
        );
        $this->tasks->save($task);
        return $task;
    }

    public function createComment(string $text, int $taskId, int $userId): Comments
    {
        $comment = Comments::create($text, $taskId, $userId);
        $comment->save();
        return Comments::findOne($comment->id);
    }

    public function createFakeData(): void
    {
        $faker = Factory::create();
        for ($i = 1; $i <= 10; $i++) {
            $project = Projects::create(
                $faker->text(15),
                $faker->text(),
            );
            $project->save();
        }

        for ($i = 1; $i <= 50; $i++) {
            $task = Tasks::create(
                $faker->text(15),
                $faker->text(),
                $faker->numberBetween(1, 7),
                $faker->numberBetween(1, 2),
                date('Y-m-d H:i:s'),
                $faker->numberBetween(1, 10),
                );
            $this->tasks->save($task);
        }
    }

    public function cacheDataProvider($dataProvider): void
    {
        $dependency = new DbDependency;
        $dependency->sql = <<<sql
                SELECT `updated_at` FROM {$this->tasks->tableName()} ORDER BY `updated_at` DESC LIMIT 1
            sql;
        Tasks::getDb()->cache(function ($db) use ($dataProvider) {
            return $dataProvider->prepare();
        }, 60, $dependency);
    }
}