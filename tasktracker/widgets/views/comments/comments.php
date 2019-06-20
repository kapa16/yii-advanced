<?php

use tasktracker\entities\task\Tasks;
use tasktracker\forms\task\CommentForm;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

/* @var $dataProvider ArrayDataProvider */
/* @var $commentForm CommentForm */
/* @var $task Tasks */

?>

<div class="comments">
    <h3>Comments</h3>

    <div>
        <?php $form = ActiveForm::begin([
                'action' => ['comment', 'id' => $task->id],

        ]) ?>
        <?= $form->field($commentForm, 'text')->textarea()->label('') ?>
        <?= Html::submitButton('Add', ['class' => 'btn btn-primary form-control col-md-2']) ?>
        <?php ActiveForm::end() ?>
    </div>

    <p></p>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => 'comment',
        'layout' => "{items}\n{pager}",
    ]) ?>
</div>