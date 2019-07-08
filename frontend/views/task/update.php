<?php

use tasktracker\entities\task\Tasks;
use tasktracker\forms\task\ImageForm;
use tasktracker\forms\task\TaskForm;
use tasktracker\widgets\CommentsWidget;
use yii\helpers\Html;
use yii\widgets\Pjax;

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

    <?= $this->render('_form', [
        'model' => $model,
        'title' => $this->title,
    ]) ?>

    <div class="row">
        <div class="col-md-6 comments">

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
