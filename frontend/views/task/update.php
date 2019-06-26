<?php

use tasktracker\entities\task\Tasks;
use tasktracker\forms\task\ImageForm;
use tasktracker\forms\task\TaskForm;
use tasktracker\widgets\CommentsWidget;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model TaskForm */
/* @var $task Tasks */
/* @var $imageForm ImageForm */

$this->title = $model->translateControl('edit') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Edit';

?>
<div class="task-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    <div class="row">
        <div class="col-md-6">
            <?= CommentsWidget::widget([
                'task' => $task
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= $this->render('images/_images', [
                    'task' => $task,
                    'model' => $imageForm
            ]) ?>
        </div>
    </div>

</div>
