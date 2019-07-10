<?php

use tasktracker\forms\task\TaskForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $model TaskForm */


$this->title = 'New task';
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'project')->dropDownList($model->projectsList()) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="row">
        <div class="col-md-5">
            <?= $form->field($model, 'status')->dropDownList($model->statusList()) ?>
        </div>
        <div class="col-md-offset-2 col-md-5">
            <?= $form->field($model, 'deadline')
                ->widget(DatePicker::class, [
                    'options' => ['class' => 'form-control'],
                ]) ?>
        </div>
    </div>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="row">
        <div class="col-md-5">
            <?= $form->field($model, 'responsible')->dropDownList($model->responsibleList()) ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>