<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comments}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%tasks}}`
 * - `{{%users}}`
 */
class m190610_112759_create_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comments}}', [
            'id' => $this->primaryKey(),
            'text' => $this->text()->notNull(),
            'task_id' => $this->integer(),
            'author_id' => $this->integer(),
            'created_at' => $this->datetime(),
            'updated_at' => $this->datetime(),
        ]);

        // creates index for column `task_id`
        $this->createIndex(
            '{{%idx-comments-task_id}}',
            '{{%comments}}',
            'task_id'
        );

        // add foreign key for table `{{%tasks}}`
        $this->addForeignKey(
            '{{%fk-comments-task_id}}',
            '{{%comments}}',
            'task_id',
            '{{%tasks}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // creates index for column `author_id`
        $this->createIndex(
            '{{%idx-comments-author_id}}',
            '{{%comments}}',
            'author_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-comments-author_id}}',
            '{{%comments}}',
            'author_id',
            '{{%users}}',
            'id',
            'CASCADE',
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
            '{{%fk-comments-task_id}}',
            '{{%comments}}'
        );

        // drops index for column `task_id`
        $this->dropIndex(
            '{{%idx-comments-task_id}}',
            '{{%comments}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-comments-author_id}}',
            '{{%comments}}'
        );

        // drops index for column `author_id`
        $this->dropIndex(
            '{{%idx-comments-author_id}}',
            '{{%comments}}'
        );

        $this->dropTable('{{%comments}}');
    }
}
