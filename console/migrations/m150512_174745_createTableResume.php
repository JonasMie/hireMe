<?php

use yii\db\Schema;
use yii\db\Migration;

class m150512_174745_createTableResume extends Migration
{
    public function up()
    {
        $this->createTable('resume', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER .' not null',
            'begin' => Schema::TYPE_DATE,
            'end' => Schema::TYPE_DATE,
            'company_id' => Schema::TYPE_INTEGER . ' not null',
            'type' => Schema::TYPE_STRING . ' not null',
            'current' => Schema::TYPE_BOOLEAN
        ]);

        $this->addForeignKey('resume_company_rel', 'resume', 'company_id', 'company', 'id');
        $this->addForeignKey('resume_user_rel', 'resume', 'user_id', 'user', 'id');

    }

    public function down()
    {
        echo "m150512_174745_createTableResume cannot be reverted.\n";

        return false;
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
