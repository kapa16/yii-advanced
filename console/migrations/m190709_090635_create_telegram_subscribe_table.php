<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%telegram_subscribe}}`.
 */
class m190709_090635_create_telegram_subscribe_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%telegram_subscribe}}', [
            'id' => $this->primaryKey(),
            'telegram_id' => $this->integer()->notNull(),
            'target' => $this->string(100),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%telegram_subscribe}}');
    }
}
