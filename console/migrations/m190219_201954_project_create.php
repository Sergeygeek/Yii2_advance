<?php

use yii\db\Migration;

/**
 * Class m190219_201954_project_create
 */
class m190219_201954_project_create extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('project', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'active' => $this->boolean()->notNull()->defaultValue(0),
            'creator_id' => $this->integer()->notNull(),
            'updater_id' => $this->integer()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->null()
        ]);
        $this->addForeignKey('fx_project_user1', 'project', 'creator_id', 'user', ['id']);
        $this->addForeignKey('fx_project_user2', 'project', 'updater_id', 'user', ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fx_project_user1', 'project');
        $this->dropForeignKey('fx_project_user2', 'project');
        $this->dropTable('project');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190219_201954_project_create cannot be reverted.\n";

        return false;
    }
    */
}
