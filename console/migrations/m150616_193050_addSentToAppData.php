<?php

use yii\db\Schema;
use yii\db\Migration;

class m150616_193050_addSentToAppData extends Migration
{
    public function up()
    {
      $this->addColumn("application_data","sent",Schema::TYPE_INTEGER);
    }

    public function down()
    {
        echo "m150616_193050_addSentToAppData cannot be reverted.\n";

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
