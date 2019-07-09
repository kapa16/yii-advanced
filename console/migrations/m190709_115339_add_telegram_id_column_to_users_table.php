<?php

use yii\db\Migration;

/**
 * Handles adding telegram_id to table `{{%users}}`.
 */
class m190709_115339_add_telegram_id_column_to_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%users}}', 'telegram_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%users}}', 'telegram_id');
    }
}
