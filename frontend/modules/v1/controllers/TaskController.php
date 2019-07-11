<?php

namespace frontend\modules\v1\controllers;

use tasktracker\entities\task\Tasks;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;

class TaskController extends ActiveController
{
    public $modelClass = Tasks::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];
        return $behaviors;
    }
}