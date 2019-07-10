<?php

namespace frontend\modules\v1\controllers;

use tasktracker\entities\task\Tasks;
use yii\rest\ActiveController;

class TaskController extends ActiveController
{
    public $modelClass = Tasks::class;
}