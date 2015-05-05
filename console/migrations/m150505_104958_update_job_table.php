<?php

use yii\db\Schema;
use yii\db\Migration;

class m150505_104958_update_job_table extends Migration
{
    public function up()
    {
    
        $this->addColumn('job', 'title', 'varchar(100)');

    }

    public function down()
    {
        echo "m150505_104958_update_job_table cannot be reverted.\n";

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
