<?php

namespace tasktracker\entities\project;

use common\models\Users;
use tasktracker\entities\task\Tasks;
use tasktracker\repositories\StatusRepository;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "projects".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $creator_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Users $creator
 * @property Tasks[] $tasks
 */
class Projects extends ActiveRecord
{
    public static function create(string $name, string $description)
    {
        $project = new static();
        $project->name = $name;
        $project->description = $description;
        return $project;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'projects';
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
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['creator_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['creator_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'creator_id' => 'Creator ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCreator(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'creator_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTasks(): ActiveQuery
    {
        return $this->hasMany(Tasks::class, ['project_id' => 'id']);
    }
}
