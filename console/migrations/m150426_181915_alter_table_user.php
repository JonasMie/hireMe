<?php

use yii\db\Schema;
use yii\db\Migration;

class m150426_181915_alter_table_user extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->dropForeignKey('user_auth_rel', 'auth');
        $this->dropTable('user');
        $this->createTable('{{%user}}', [
            'id' => Schema::TYPE_PK,
            'firstName' => Schema::TYPE_STRING . ' NOT NULL',
            'lastName' => Schema::TYPE_STRING . ' NOT NULL',
            'auth_key' => Schema::TYPE_STRING . '(32) NOT NULL',
            'password_hash' => Schema::TYPE_STRING . ' NOT NULL',
            'password_reset_token' => Schema::TYPE_STRING,
            'email' => Schema::TYPE_STRING . ' NOT NULL',

            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10',
            'is_recruiter' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0',
            'company_id' => Schema::TYPE_INTEGER,
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
        $this->addForeignKey('user_company_rel', 'user', 'company_id', 'company', 'id');
        $this->addForeignKey('user_auth_rel', 'auth', 'user_id', 'user', 'id');

    }

    public function down()
    {
        $this->dropForeignKey('user_auth_rel', 'auth');
//        $this->dropTable('{{%user}}');
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
