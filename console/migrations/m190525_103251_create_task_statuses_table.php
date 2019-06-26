<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task_statuses}}`.
 */
class m190525_103251_create_task_statuses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task_statuses}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50),
        ]);

        $this->batchInsert('{{%task_statuses}}', ['name'], [
            ['New'],
            ['In work'],
            ['Done'],
            ['Testing'],
            ['Canceled'],
            ['Revision'],
            ['Closed'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%task_statuses}}');
    }
}
