<?php

use yii\db\Schema;
use yii\db\Migration;

class m150609_224506_deleteCompanyConstraints extends Migration
{
    public function up()
    {
        $this->db->createCommand("ALTER TABLE `company` CHANGE `street` `street` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;
ALTER TABLE `company` CHANGE `houseno` `houseno` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;
ALTER TABLE `company` CHANGE `zip` `zip` VARCHAR(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;
ALTER TABLE `company` CHANGE `city` `city` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;
ALTER TABLE `company` CHANGE `sector` `sector` TINYINT(3) UNSIGNED NULL;
ALTER TABLE `company` CHANGE `employeeAmount` `employeeAmount` TINYINT(3) UNSIGNED NULL;")->execute();


    }

    public function down()
    {
        echo "m150609_224506_deleteCompanyConstraints cannot be reverted.\n";

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
