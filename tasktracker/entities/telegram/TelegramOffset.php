<?php

namespace tasktracker\entities\telegram;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "telegram_offset".
 *
 * @property int $id
 * @property string $timestamp_offset
 */
class TelegramOffset extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'telegram_offset';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['timestamp_offset'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'timestamp_offset' => 'Timestamp Offset',
        ];
    }
}
