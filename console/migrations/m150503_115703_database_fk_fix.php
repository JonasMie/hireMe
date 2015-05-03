<?php

use yii\db\Schema;
use yii\db\Migration;

class m150503_115703_database_fk_fix extends Migration
{
    public function up()
    {
        $this->alterColumn('user', 'password_hash', SCHEMA::TYPE_STRING);
        $this->dropColumn('user', 'applications_id');

    }

    public function down()
    {
        echo "m150503_115703_database_fk_fix cannot be reverted.\n";

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
