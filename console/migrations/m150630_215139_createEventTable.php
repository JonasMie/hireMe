<?php

use yii\db\Schema;
use yii\db\Migration;

class m150630_215139_createEventTable extends Migration
{
    public function up()
    {
        $this->createTable("event",
            [
                'id' => Schema::TYPE_PK,
                'description' => Schema::TYPE_TEXT,
                'user_id' => Schema::TYPE_INTEGER,
                'latitude' => 'decimal(10,8)',
                'longitude' => 'decimal(11,8)',
                'begin' => Schema::TYPE_DATETIME,
                'end' => Schema::TYPE_DATETIME,
            ]);

        $this->addColumn('job','event_id',Schema::TYPE_INTEGER);
    }

    public function down()
    {
        echo "m150630_215139_createEventTable cannot be reverted.\n";

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
