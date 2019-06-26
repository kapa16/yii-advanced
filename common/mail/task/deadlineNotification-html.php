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
    <p>Hello <?= Html::encode($user->name . ' ' . $user->last_name) ?>,</p>

    <p>Deadline date is <?= Html::encode($task->deadline) ?></p>

    <p>Follow the link below to open task:</p>

    <p><?= Html::a(Html::encode($taskLink), $taskLink) ?></p>

</div>
