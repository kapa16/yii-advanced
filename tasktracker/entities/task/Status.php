<?php

namespace tasktracker\entities\task;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "task_statuses".
 *
 * @property int $id
 * @property string $name
 */
class Status extends ActiveRecord
{
    public const NEW = 1;
    public const WORK = 2;
    public const DONE = 3;
    public const TESTING = 4;
    public const CANCELLED = 5;
    public const REVISION = 6;
    public const CLOSED = 7;


    public static function tableName()
    {
        return 'task_statuses';
    }

}