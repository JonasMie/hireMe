<?php

use yii\db\Schema;
use yii\db\Migration;

class m150621_150858_deleteForSender extends Migration
{
    public function up()
    {
        $this->renameColumn('message', 'deleted', 'deleted_sender');
        $this->addColumn('message', 'deleted_receiver', Schema::TYPE_BOOLEAN . ' DEFAULT 0');
    }

    public function down()
    {
        echo "m150621_150858_deleteForSender cannot be reverted.\n";

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
