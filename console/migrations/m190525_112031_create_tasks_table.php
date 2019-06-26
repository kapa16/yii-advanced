<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tasks}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%statuses}}`
 * - `{{%users}}`
 * - `{{%users}}`
 */
class m190525_112031_create_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tasks}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'description' => $this->text(),
            'status_id' => $this->integer()->defaultValue(1),
            'creator_id' => $this->integer(),
            'responsible_id' => $this->integer(),
            'deadline' => $this->datetime(),
            'created_at' => $this->datetime()->defaultValue(date('Y-m-d H:i:s')),
            'updated_at' => $this->datetime(),
        ]);

        // creates index for column `status_id`
        $this->createIndex(
            '{{%idx-tasks-status_id}}',
            '{{%tasks}}',
            'status_id'
        );

        // add foreign key for table `{{%statuses}}`
        $this->addForeignKey(
            '{{%fk-tasks-status_id}}',
            '{{%tasks}}',
            'status_id',
            '{{%task_statuses}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // creates index for column `creator_id`
        $this->createIndex(
            '{{%idx-tasks-creator_id}}',
            '{{%tasks}}',
            'creator_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-tasks-creator_id}}',
            '{{%tasks}}',
            'creator_id',
            '{{%users}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // creates index for column `responsible_id`
        $this->createIndex(
            '{{%idx-tasks-responsible_id}}',
            '{{%tasks}}',
            'responsible_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-tasks-responsible_id}}',
            '{{%tasks}}',
            'responsible_id',
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
        // drops foreign key for table `{{%statuses}}`
        $this->dropForeignKey(
            '{{%fk-tasks-status_id}}',
            '{{%tasks}}'
        );

        // drops index for column `status_id`
        $this->dropIndex(
            '{{%idx-tasks-status_id}}',
            '{{%tasks}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-tasks-creator_id}}',
            '{{%tasks}}'
        );

        // drops index for column `creator_id`
        $this->dropIndex(
            '{{%idx-tasks-creator_id}}',
            '{{%tasks}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-tasks-responsible_id}}',
            '{{%tasks}}'
        );

        // drops index for column `responsible_id`
        $this->dropIndex(
            '{{%idx-tasks-responsible_id}}',
            '{{%tasks}}'
        );

        $this->dropTable('{{%tasks}}');
    }
}
