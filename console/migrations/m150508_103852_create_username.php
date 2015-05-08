<?php

use yii\db\Schema;
use yii\db\Migration;

class m150508_103852_create_username extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'username', Schema::TYPE_STRING);
        if (YII_ENV_PROD){
            $this->addColumn('user', 'username', 'string not null');
        }
        $this->createIndex('unique_username', 'user', 'username', true);


    }

    public function down()
    {
        echo "m150508_103852_create_username cannot be reverted.\n";

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
