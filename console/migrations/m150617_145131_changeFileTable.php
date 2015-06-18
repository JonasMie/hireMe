<?php

use yii\db\Schema;
use yii\db\Migration;

class m150617_145131_changeFileTable extends Migration
{
    public function up()
    {
        $this->dropColumn("application_data","sent");
        $this->addColumn("file","user_id",Schema::TYPE_INTEGER);
        $this->addForeignKey("userForeignKey","file","user_id","user","id","CASCADE");

    }

    public function down()
    {
        echo "m150617_145131_changeFileTable cannot be reverted.\n";

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
