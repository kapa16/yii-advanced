<?php

use common\widgets\Alert;
use tasktracker\forms\task\TaskForm;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this View */
/* @var $model TaskForm */
/* @var $form ActiveForm */
/* @var $title string */

?>

<?php Pjax::begin([
    'enablePushState' => false,
    'id' => 'task_update_form',
]) ?>

<h1><?= Html::encode($title) ?></h1>

<div class="task-form">

    <?php $form = ActiveForm::begin(['options' => ['data' => ['pjax' => true]]]); ?>

    <?= Alert::widget() ?>

    <div class="form-group">
        <?= Html::submitButton(
            $model->translateControl('save'),
            ['class' => 'btn btn-success']
        ) ?>
        <?= Html::a(
            $model->translateControl('delete'),
            ['delete', 'id' => $model['id']],
            ['class' => 'btn btn-danger']
        ) ?>
    </div>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'status')->dropDownList($model->statusList()) ?>
        </div>
        <div class="col-md-offset-1 col-md-5">
            <?= $form->field($model, 'deadline')
                ->widget(DatePicker::class, [
                    'options' => ['class' => 'form-control'],
                ]) ?>
        </div>
    </div>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'responsible')->dropDownList($model->responsibleList()) ?>
        </div>
        <div class="col-md-offset-1 col-md-5">
            <?= $form->field($model, 'created_at')->textInput(['disabled' => '']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form
                ->field($model->creator, 'username')
                ->textInput(['disabled' => ''])
                ->label($model->translateTask('creator')) ?>
        </div>
        <div class="col-md-offset-1 col-md-5">
            <?= $form->field($model, 'updated_at')->textInput(['disabled' => '']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php Pjax::end() ?>
