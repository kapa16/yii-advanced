<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%telegram_offset}}`.
 */
class m190708_165916_create_telegram_offset_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%telegram_offset}}', [
            'id' => $this->integer(),
            'timestamp_offset' => $this->timestamp()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%telegram_offset}}');
    }
}
