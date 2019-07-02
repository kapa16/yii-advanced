<?php

namespace tasktracker\entities\task;

use common\models\Users;
use tasktracker\behaviors\TranslateBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $status_id
 * @property int $creator_id
 * @property int $responsible_id
 * @property string $deadline
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Users $creator
 * @property Users $responsible
 * @property ActiveQuery $comments
 * @property ActiveQuery $images
 * @property Status $status
 *
 * @mixin TranslateBehavior
 */
class Tasks extends ActiveRecord
{

    public static function create(
        $name,
        $description,
        $status_id,
        $responsible_id,
        $deadline
    ): self
    {
        $task = new static();
        $task->name = $name;
        $task->description = $description;
        $task->status_id = $status_id;
        $task->responsible_id = $responsible_id;
        $task->deadline = $deadline;
        return $task;
    }

    public function edit($name, $description, $status_id, $responsible_id, $deadline): void
    {
        $this->name = $name;
        $this->description = $description;
        $this->status_id = $status_id;
        $this->responsible_id = $responsible_id;
        $this->deadline = $deadline;
    }

    public static function tableName(): string
    {
        return 'tasks';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'creator_id',
                'updatedByAttribute' => null,
            ],
            [
                'class' => TranslateBehavior::class
            ],
        ];
    }

    public function getCreator(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'creator_id']);
    }

    public function getResponsible(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'responsible_id']);
    }

    public function getStatus(): ActiveQuery
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
    }

    public function getComments(): ActiveQuery
    {
        return $this->hasMany(Comments::class, ['task_id' => 'id']);
    }

    public function getImages(): ActiveQuery
    {
        return $this->hasMany(Images::class, ['task_id' => 'id']);
    }
}
