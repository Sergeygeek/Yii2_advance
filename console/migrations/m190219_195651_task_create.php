<?php

use yii\db\Migration;

/**
 * Class m190219_195651_task_create
 */
class m190219_195651_task_create extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('task', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'project_id' => $this->integer()->null(),
            'executor_id' => $this->integer()->null(),
            'started_at' => $this->integer()->null(),
            'completed_at' => $this->integer()->null(),
            'creator_id' => $this->integer()->notNull(),
            'updater_id' => $this->integer()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->null()
        ]);
        $this->addForeignKey('fx_task_user1', 'task', 'executor_id', 'user', ['id']);
        $this->addForeignKey('fx_task_user2', 'task', 'creator_id', 'user', ['id']);
        $this->addForeignKey('fx_task_user3', 'task', 'updater_id', 'user', ['id']);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Можно конечно было сразу дропнуть таблицу, но решил что лучше сначала удалить ключи
        $this->dropForeignKey('fx_task_user1', 'task');
        $this->dropForeignKey('fx_task_user2', 'task');
        $this->dropForeignKey('fx_task_user3', 'task');
        $this->dropTable('task');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190219_195651_task_create cannot be reverted.\n";

        return false;
    }
    */
}
