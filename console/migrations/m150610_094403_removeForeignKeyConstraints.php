<?php

use yii\db\Schema;
use yii\db\Migration;

class m150610_094403_removeForeignKeyConstraints extends Migration
{
    public function up()
    {
        $this->db->createCommand("ALTER TABLE `resume_job` DROP FOREIGN KEY `resume_company_rel`; ALTER TABLE `resume_job` ADD CONSTRAINT `resume_company_rel` FOREIGN KEY (`company_id`) REFERENCES `hireme`.`company`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;")->execute();
    }

    public function down()
    {
        echo "m150610_094403_removeForeignKeyConstraints cannot be reverted.\n";

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
