<?php

use yii\db\Schema;
use yii\db\Migration;

class m150507_195223_multiple_job_contacts extends Migration
{
    public function up()
    {
        $this->createTable('job_contacts', [
            'id' => Schema::TYPE_PK,
            'job_id' => Schema::TYPE_INTEGER,
            'contact_id' => Schema::TYPE_INTEGER
        ]);

        $this->dropForeignKey('job_recruiter_ref', 'job');
        $this->dropColumn('job', 'contact_id');

        $this->addForeignKey('job_ref', 'job_contacts', 'job_id', 'job', 'id');
        $this->addForeignKey('contact_ref', 'job_contacts', 'contact_id', 'user', 'id');

    }

    public function down()
    {
        echo "m150507_195223_multiple_job_contacts cannot be reverted.\n";

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
