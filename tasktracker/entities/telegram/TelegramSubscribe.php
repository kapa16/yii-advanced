<?php

namespace tasktracker\entities\telegram;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "telegram_subscribe".
 *
 * @property int $id
 * @property int $telegram_id
 * @property string $target
 */
class TelegramSubscribe extends ActiveRecord
{
    public static function create($telegram_id, $target)
    {
        $subscribe = new self();
        $subscribe->telegram_id = $telegram_id;
        $subscribe->target = $target;
        return $subscribe;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'telegram_subscribe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['telegram_id'], 'required'],
            [['telegram_id'], 'integer'],
            [['target'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'telegram_id' => 'Telegram ID',
            'target' => 'Target',
        ];
    }
}
