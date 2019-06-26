<?php

namespace tasktracker\widgets;

use yii\bootstrap\Widget;

class TaskCard extends Widget
{
    public $model;

    public function run()
    {
        return $this->render('task_card', [
            'model' => $this->model,
        ]);
    }

}
