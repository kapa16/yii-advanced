<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task_images}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%tasks}}`
 */
class m190610_153157_create_task_images_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task_images}}', [
            'id' => $this->primaryKey(),
            'file' => $this->string()->notNull(),
            'preview' => $this->string()->notNull(),
            'alt' => $this->string()->notNull(),
            'task_id' => $this->integer(),
            'created_at' => $this->datetime(),
        ]);

        // creates index for column `task_id`
        $this->createIndex(
            '{{%idx-task_images-task_id}}',
            '{{%task_images}}',
            'task_id'
        );

        // add foreign key for table `{{%tasks}}`
        $this->addForeignKey(
            '{{%fk-task_images-task_id}}',
            '{{%task_images}}',
            'task_id',
            '{{%tasks}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%tasks}}`
        $this->dropForeignKey(
            '{{%fk-task_images-task_id}}',
            '{{%task_images}}'
        );

        // drops index for column `task_id`
        $this->dropIndex(
            '{{%idx-task_images-task_id}}',
            '{{%task_images}}'
        );

        $this->dropTable('{{%task_images}}');
    }
}
