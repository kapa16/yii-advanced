<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%projects}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 */
class m190708_133646_create_projects_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%projects}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'description' => $this->text(),
            'creator_id' => $this->integer(),
            'created_at' => $this->datetime(),
            'updated_at' => $this->datetime(),
        ]);

        // creates index for column `creator_id`
        $this->createIndex(
            '{{%idx-projects-creator_id}}',
            '{{%projects}}',
            'creator_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-projects-creator_id}}',
            '{{%projects}}',
            'creator_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-projects-creator_id}}',
            '{{%projects}}'
        );

        // drops index for column `creator_id`
        $this->dropIndex(
            '{{%idx-projects-creator_id}}',
            '{{%projects}}'
        );

        $this->dropTable('{{%projects}}');
    }
}
