<?php

use tasktracker\entities\task\Tasks;
use yii\helpers\Html;

/* @var $task Tasks */

$this->title = 'Task';
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

 ?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="user-index">

    <p>
        <?= Html::a('Edit', ['update', 'id' => $task['id']], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $task['id']], ['class' => 'btn btn-danger']) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <h3><?=$task->name?></h3>
            <hr>
            <div class="row">
                <div class="col-md-4"><strong>Status:</strong> <?=$task->status->name?></div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <strong>Description:</strong>
                    <p><?=$task->description?></p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6"><strong>Author:</strong> <?=$task->creator->username?></div>
                <div class="col-md-6"><strong>Implementer:</strong> <?=$task->responsible->username?></div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4"><strong>Deadline:</strong> <?=Yii::$app->formatter->asDate($task->deadline)?></div>
                <div class="col-md-4"><strong>Created:</strong> <?=Yii::$app->formatter->asDate($task->created_at)?></div>
                <div class="col-md-4"><strong>Updated:</strong> <?=Yii::$app->formatter->asDate($task->updated_at)?></div>
            </div>
        </div>
    </div>

</div>
