<?php

/* @var $model Tasks */

use tasktracker\entities\task\Tasks;
use yii\helpers\Html;
use yii\helpers\StringHelper;

$description = StringHelper::truncate($model->description, 40);

$str = <<<card
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">{$model->name}
                <span class="label label-success pull-right">{$model->deadline}</span>
                <span class="pull-right">&nbsp;</span>
                <span class="label label-info pull-right">{$model->status->name}</span>
            </div>
            <div class="panel-body">
                 {$description}
            </div>
        </div>   
    </div>

card;


echo Html::a($str, ['task/update', 'id' => $model->id]);
