<?php

use yii\db\Schema;
use yii\db\Migration;

class m150426_175629_create_company_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%company}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'street' => Schema::TYPE_STRING . ' NOT NULL',
            'houseno' => Schema::TYPE_STRING . ' NOT NULL',
            'zip' => 'VARCHAR(10) NOT NULL',
            'city' => Schema::TYPE_STRING . ' NOT NULL',
            'sector' => 'TINYINT unsigned NOT NULL',
            'employeeAmountCat' => 'TINYINT unsigned NOT NULL'
        ], $tableOptions);
    }

    public function down()
    {
//        $this->dropForeignKey('user_company_rel', 'user');
        $this->dropTable('{{%company}}');

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
