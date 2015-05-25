<?php

use yii\db\Schema;
use yii\db\Migration;

class m150513_130029_applyBtn_Table extends Migration
{
    public function up()
    {
        $this->createTable('applyBtn', [
            'id' => Schema::TYPE_PK,
            'job_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'key' => Schema::TYPE_TEXT,
            'site' => Schema::TYPE_TEXT,
            'clickCount' => Schema::TYPE_INTEGER,
        ]);

        $this->addForeignKey('FK_btn_job', 'applyBtn', 'job_id', 'job', 'id', 'CASCADE', 'CASCADE');


    }

    public function down()
    {
        echo "m150513_130029_applyBtn_Table cannot be reverted.\n";

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
