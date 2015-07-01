<?php

use yii\db\Schema;
use yii\db\Migration;

class m150701_154453_addArchivedToBtn extends Migration
{
    public function up()
    {
        $this->addColumn("applyBtn","archived",Schema::TYPE_INTEGER);
    }

    public function down()
    {
        echo "m150701_154453_addArchivedToBtn cannot be reverted.\n";

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
