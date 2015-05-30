<?php

use yii\db\Schema;
use yii\db\Migration;

class m150525_112042_add_profile_visibility extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'visibility', Schema::TYPE_INTEGER .' not null');
    }

    public function down()
    {
        echo "m150525_112042_add_profile_visibility cannot be reverted.\n";

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
