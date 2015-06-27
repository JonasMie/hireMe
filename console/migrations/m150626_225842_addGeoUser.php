<?php

use yii\db\Schema;
use yii\db\Migration;

class m150626_225842_addGeoUser extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'geo_id', Schema::TYPE_INTEGER);
        $this->addPrimaryKey('geo_pk', 'geo', 'id');
        $this->addForeignKey('user_geo_rel', 'user', 'geo_id', 'geo', 'id');
    }

    public function down()
    {
        echo "m150626_225842_addGeoUser cannot be reverted.\n";

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
