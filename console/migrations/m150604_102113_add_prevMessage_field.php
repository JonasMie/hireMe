<?php

use yii\db\Schema;
use yii\db\Migration;

class m150604_102113_add_prevMessage_field extends Migration
{
    public function up()
    {

        $this->addColumn('message', 'flow', Schema::TYPE_INTEGER .' not null ');
//        $this->addColumn('message', 'prev', Schema::TYPE_INTEGER);
//        $this->addForeignKey('message_prev_rel', 'message', 'prev', 'message', 'id');
    }

    public function down()
    {
        echo "m150604_102113_add_prevMessage_field cannot be reverted.\n";

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
