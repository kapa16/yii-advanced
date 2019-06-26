<?php

namespace tasktracker\forms\task;

use yii\base\Model;

class CommentForm extends Model
{
    public $text;

    public function rules():array
    {
        return [
            ['text', 'required'],
            ['text', 'string'],
        ];
    }
}