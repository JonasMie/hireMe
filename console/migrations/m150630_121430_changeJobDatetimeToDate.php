<?php

use yii\db\Schema;
use yii\db\Migration;

class m150630_121430_changeJobDatetimeToDate extends Migration
{
    public function up()
    {
        $this->alterColumn('job', 'job_begin', Schema::TYPE_DATE);
        $this->alterColumn('job', 'job_end', Schema::TYPE_DATE);
    }

    public function down()
    {
        echo "m150630_121430_changeJobDatetimeToDate cannot be reverted.\n";

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
