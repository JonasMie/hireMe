<?php

use yii\db\Schema;
use yii\db\Migration;

class m150623_144457_addDateToEvents extends Migration
{
    public function up()
    {

        $this->addColumn("event","begin",Schema::TYPE_DATE);
        $this->addColumn("event","end",Schema::TYPE_DATE);
    }

    public function down()
    {
        echo "m150623_144457_addDateToEvents cannot be reverted.\n";

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
