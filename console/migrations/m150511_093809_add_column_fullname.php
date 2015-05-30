<?php

use yii\db\Schema;
use yii\db\Migration;

class m150511_093809_add_column_fullname extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'fullName', 'string not null');
    }

    public function down()
    {
        echo "m150511_093809_add_column_fullname cannot be reverted.\n";

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
