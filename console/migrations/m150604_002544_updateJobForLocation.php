<?php

use yii\db\Schema;
use yii\db\Migration;

class m150604_002544_updateJobForLocation extends Migration
{
    public function up()
    {
        $this->alterColumn("job","city","string null");
    }

    public function down()
    {
        echo "m150604_002544_updateJobForLocation cannot be reverted.\n";

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
