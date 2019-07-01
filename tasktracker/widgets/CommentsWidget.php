<?php

namespace tasktracker\widgets;

use tasktracker\entities\task\Tasks;
use tasktracker\forms\task\CommentForm;
use yii\bootstrap\Widget;
use yii\data\ActiveDataProvider;

class CommentsWidget extends Widget
{
    /** @var Tasks $task */
    public $task;

    public function run()
    {
        $form = new CommentForm();

        $comments = $this->task->getComments();
        $dataProvider = new ActiveDataProvider([
            'query' => $comments,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ]
        ]);

        return $this->render('comments/comments', [
            'task' => $this->task,
            'commentForm' => $form,
            'dataProvider' => $dataProvider
        ]);
    }
}