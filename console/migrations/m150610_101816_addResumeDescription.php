<?php

use yii\db\Schema;
use yii\db\Migration;

class m150610_101816_addResumeDescription extends Migration
{
    public function up()
    {
        $this->addColumn('resume_job', 'description', Schema::TYPE_STRING);
    }

    public function down()
    {
        echo "m150610_101816_addResumeDescription cannot be reverted.\n";

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
