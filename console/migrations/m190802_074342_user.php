<?php

use yii\db\Migration;

/**
 * Class m190802_074342_user
 */
class m190802_074342_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('com_role', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->defaultValue(''),
            'mark' => $this->string(255)->notNull()->defaultValue(''),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'deleted' => $this->tinyInteger()->notNull()->defaultValue(0),
        ], $tableOptions);

        $this->createTable('com_role_menu', [
            'id' => $this->primaryKey(),
            'role_id' => $this->integer()->notNull()->defaultValue(0),
            'menu_id' => $this->integer()->notNull()->defaultValue(0),
            'deleted' => $this->tinyInteger()->notNull()->defaultValue(0),
        ], $tableOptions);
        $this->createIndex('idx_role_id', 'com_role_menu', 'role_id');


        $this->createTable('com_menu', [
            'id' => $this->primaryKey(),
            'pid' => $this->integer()->notNull()->defaultValue(0),
            'name' => $this->string(50)->notNull()->defaultValue(''),
            'route' => $this->string(50)->notNull()->defaultValue(''),
            'type' => $this->smallInteger()->notNull()->defaultValue(0)->comment("1普通,2权限"),
            'mark' => $this->string(255)->notNull()->defaultValue(''),
            'sort' => $this->smallInteger()->notNull()->defaultValue(0)->comment("by asc"),
            'style' => $this->string(50)->notNull()->defaultValue('')->comment("css className"),
            'status' => $this->tinyInteger()->notNull()->defaultValue(0)->comment("0启用,1禁用"),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'deleted' => $this->tinyInteger()->notNull()->defaultValue(0),
        ], $tableOptions);
        $this->createIndex('idx_route', 'com_menu', 'route');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190802_074342_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190802_074342_user cannot be reverted.\n";

        return false;
    }
    */
}
