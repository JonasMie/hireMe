<?php

use yii\db\Schema;
use yii\db\Migration;

class m150602_192841_add_mime_and_size extends Migration
{
    public function up()
    {
        $this->addColumn('file', 'extension', Schema::TYPE_STRING);
        $this->addColumn('file', 'size', Schema::TYPE_INTEGER);
        $this->addColumn('file', 'title', Schema::TYPE_STRING);
    }

    public function down()
    {
        echo "m150602_192841_add_mime_and_size cannot be reverted.\n";

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
