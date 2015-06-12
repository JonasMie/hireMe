<?php

use yii\db\Schema;
use yii\db\Migration;

class m150612_220201_setDefaultVisibility extends Migration
{
    public function up()
    {
        $this->db->createCommand("ALTER TABLE `user` CHANGE `visibility` `visibility` INT(11) NOT NULL DEFAULT '2'")->execute();
    }

    public function down()
    {
        echo "m150612_220201_setDefaultVisibility cannot be reverted.\n";

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
