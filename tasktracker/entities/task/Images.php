<?php

namespace tasktracker\entities\task;

use tasktracker\forms\task\ImageForm;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "task_images".
 *
 * @property int $id
 * @property string $file
 * @property string $preview
 * @property string $alt
 * @property int $task_id
 * @property string $created_at
 *
 * @property Tasks $task
 */
class Images extends ActiveRecord
{
    public function create(ImageForm $form, int $taskId): void
    {
        $comment = new static();
        $comment->file = $form->file;
        $comment->preview = $form->preview;
        $comment->alt = $form->alt;
        $comment->task_id = $taskId;
        $comment->save();
    }

    public static function tableName(): string
    {
        return 'task_images';
    }

    public function getTask(): ActiveQuery
    {
        return $this->hasOne(Tasks::class, ['id' => 'task_id']);
    }
}
