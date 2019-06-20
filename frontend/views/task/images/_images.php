<?php

use tasktracker\entities\task\Tasks;
use tasktracker\forms\task\ImageForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

/** @var Tasks $task */
/** @var ImageForm $model */

$dataProvider = $model->search($task);
?>

<h3>Images</h3>

<?php
$form = ActiveForm::begin([
    'action' => ['upload', 'id' => $task->id],
    'options' => ['enctype' => 'multipart/form-data'],
]) ?>

<?= $form->field($model, 'image')->fileInput()->label('') ?>

<?= Html::submitButton('Upload', ['class' => 'btn btn-primary form-control col-md-2']) ?>

<?php ActiveForm::end() ?>

<div class="row">
    <div class="col-md-12">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_image',
            'layout' => '{items}',
        ]) ?>
    </div>

    <div class="col-md-12">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_image',
            'layout' => '{pager}',
            'options' => ['class' => 'center-block']]) ?>
    </div>

</div>


