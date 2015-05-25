<?php

use yii\db\Schema;
use yii\db\Migration;

class m150525_090022_final_main_setup2 extends Migration
{
    public function up()
    {
        $this->addColumn('resume_school', 'graduation', Schema::TYPE_STRING .' not null');

    }

    public function down()
    {
        echo "m150525_090022_final_main_setup2 cannot be reverted.\n";

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
