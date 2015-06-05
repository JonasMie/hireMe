<?php

use yii\db\Schema;
use yii\db\Migration;

class m150604_120111_addTrigger extends Migration
{
    public function up()
    {
        $this->execute("
CREATE TRIGGER `add_flow` BEFORE INSERT ON `message` FOR EACH ROW BEGIN
IF NEW.flow IS NULL THEN
SET NEW.flow= (SELECT AUTO_INCREMENT FROM information_schema.tables WHERE TABLE_SCHEMA='hireme' AND TABLE_NAME='message');
END IF;
END");
    }

    public function down()
    {
        echo "m150604_120111_addTrigger cannot be reverted.\n";

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
