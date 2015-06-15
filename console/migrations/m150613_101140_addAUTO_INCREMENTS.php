<?php

use yii\db\Schema;
use yii\db\Migration;

class m150613_101140_addAUTO_INCREMENTS extends Migration
{
    public function up()
    {
//        $this->alterColumn('application','id',SCHEMA::TYPE_INTEGER .' AUTO_INCREMENT');
//        $this->alterColumn('application_data','id',SCHEMA::TYPE_INTEGER .' AUTO_INCREMENT');
//        $this->alterColumn('favourites','id',SCHEMA::TYPE_INTEGER .' AUTO_INCREMENT');
//        $this->alterColumn('job','id',SCHEMA::TYPE_INTEGER .' AUTO_INCREMENT');

    }

    public function down()
    {
        echo "m150613_101140_addAUTO_INCREMENTS cannot be reverted.\n";

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
