<?php

namespace tasktracker\entities\task;

use common\models\Users;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "comments".
 *
 * @property int $id
 * @property string $text
 * @property int $task_id
 * @property int $author_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Users $author
 * @property Tasks $task
 */
class Comments extends ActiveRecord
{
    public static function create(string $text, int $taskId, int $author_id = null): self
    {
        $comment = new static();
        $comment->text = $text;
        $comment->task_id = $taskId;
        $comment->author_id = $author_id;
        return $comment;

    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public static function tableName(): string
    {
        return 'comments';
    }

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'author_id']);
    }

    public function getTask(): ActiveQuery
    {
        return $this->hasOne(Tasks::class, ['id' => 'task_id']);
    }
}
