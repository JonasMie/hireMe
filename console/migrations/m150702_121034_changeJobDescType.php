<?php

use yii\db\Schema;
use yii\db\Migration;

class m150702_121034_changeJobDescType extends Migration
{
    public function up()
    {
        $this->alterColumn("job",'description',Schema::TYPE_TEXT);
    }

    public function down()
    {
        echo "m150702_121034_changeJobDescType cannot be reverted.\n";

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
