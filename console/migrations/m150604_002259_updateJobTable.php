<?php

use yii\db\Schema;
use yii\db\Migration;

class m150604_002259_updateJobTable extends Migration
{
    public function up()
    {
        $this->alterColumn("job","zip","int null");
    }

    public function down()
    {
        echo "m150604_002259_updateJobTable cannot be reverted.\n";

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
