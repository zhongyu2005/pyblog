<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('com_user', [
            'id' => $this->primaryKey(),
            'username' => $this->string(30)->notNull()->defaultValue(''),
            'auth_key' => $this->string(32)->notNull()->defaultValue(''),
            'password_hash' => $this->string()->notNull()->defaultValue(''),
            'password_reset_token' => $this->string()->defaultValue(''),
            'email' => $this->string()->notNull()->defaultValue(''),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'super_admin' => $this->tinyInteger()->notNull()->defaultValue(0),
            'role_id' => $this->integer()->notNull()->defaultValue(0),
            'role_name' => $this->string(50)->notNull()->defaultValue(''),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'deleted' => $this->tinyInteger()->notNull()->defaultValue(0),
        ], $tableOptions);
        $this->createIndex('idx_username', 'com_user', 'username');
    }

    public function down()
    {
        $this->dropTable('com_user');
    }
}
