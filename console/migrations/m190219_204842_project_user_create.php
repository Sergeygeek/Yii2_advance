<?php

use yii\db\Migration;

/**
 * Class m190219_204842_project_user_create
 */
class m190219_204842_project_user_create extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('project_user', [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'role' => 'enum (\'manager\', \'developer\', \'tester\')'
        ]);
        $this->addForeignKey('fx_projectuser_user', 'project_user', 'user_id', 'user', ['id']);
        $this->addForeignKey('fx_projectuser_project', 'project_user', 'project_id', 'project', ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fx_projectuser_user', 'project_user');
        $this->dropForeignKey('fx_projectuser_project', 'project_user');
        $this->dropTable('project_user');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190219_204842_project_user_create cannot be reverted.\n";

        return false;
    }
    */
}
