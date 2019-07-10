<?php

use tasktracker\entities\task\Tasks;
use common\models\Users;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $user Users */
/* @var $task Tasks */

$taskLink = Yii::$app->urlManager->createAbsoluteUrl(['task/view', 'id' => $task->id]);
?>
<div>
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>Yuo have new task: <?= Html::encode($task->name) ?></p>

    <p>Follow the link below to open task:</p>

    <p><?= Html::a(Html::encode($taskLink), $taskLink) ?></p>

</div>
