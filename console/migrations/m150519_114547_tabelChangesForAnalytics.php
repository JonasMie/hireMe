<?php

use yii\db\Schema;
use yii\db\Migration;

class m150519_114547_tabelChangesForAnalytics extends Migration
{
    public function up()
    {
        $this->addColumn("applyBtn","viewCount",SCHEMA::TYPE_INTEGER);
        $this->addColumn("application","btn_id",SCHEMA::TYPE_INTEGER);
        $this->addForeignKey("btnReferFK","application","btn_id","applyBtn","id","CASCADE","CASCADE");
    }

    public function down()
    {
        echo "m150519_114547_tabelChangesForAnalytics cannot be reverted.\n";

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
