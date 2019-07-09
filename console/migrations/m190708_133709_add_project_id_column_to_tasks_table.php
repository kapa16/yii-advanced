<?php

use yii\db\Migration;

/**
 * Handles adding project_id to table `{{%tasks}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%projects}}`
 */
class m190708_133709_add_project_id_column_to_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%tasks}}', 'project_id', $this->integer()->notNull());

        // creates index for column `project_id`
        $this->createIndex(
            '{{%idx-tasks-project_id}}',
            '{{%tasks}}',
            'project_id'
        );

        // add foreign key for table `{{%projects}}`
        $this->addForeignKey(
            '{{%fk-tasks-project_id}}',
            '{{%tasks}}',
            'project_id',
            '{{%projects}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%projects}}`
        $this->dropForeignKey(
            '{{%fk-tasks-project_id}}',
            '{{%tasks}}'
        );

        // drops index for column `project_id`
        $this->dropIndex(
            '{{%idx-tasks-project_id}}',
            '{{%tasks}}'
        );

        $this->dropColumn('{{%tasks}}', 'project_id');
    }
}
