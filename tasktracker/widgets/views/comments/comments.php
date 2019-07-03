<?php

use tasktracker\entities\task\Tasks;
use tasktracker\forms\task\CommentForm;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\web\JqueryAsset;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $dataProvider ArrayDataProvider */
/* @var $this View */
/* @var $commentForm CommentForm */
/* @var $task Tasks */

$this->registerJsFile('/js/comments.js', [
    'depends' => [JqueryAsset::class]
]);

?>

    <h3>Comments</h3>

<?php Pjax::begin() ?>

    <div>
        <?php $form = ActiveForm::begin([
            'action' => null,
            'options' => [
                'id' => 'comments_form',
                'data-task-id' => $task->id,
                'data-user-id' => Yii::$app->user->id,
                'data' => ['pjax' => true]
            ]
        ]) ?>
        <?= $form->field($commentForm, 'text')->textarea([
            'name' => 'comment_text',
        ])->label(false) ?>
        <?= Html::submitButton('Add', ['class' => 'btn btn-primary form-control col-md-2']) ?>
        <?php ActiveForm::end() ?>
    </div>

    <p></p>

<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => 'comment',
    'layout' => "{items}\n{pager}",
    'options' => [
        'class' => 'comments-list'
    ]
]) ?>

<?php Pjax::end() ?>

