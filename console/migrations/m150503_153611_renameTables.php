<?php

use yii\db\Schema;
use yii\db\Migration;

class m150503_153611_renameTables extends Migration
{
    public function up()
    {
        $this->dropColumn('user', 'applications_id');
        $this->alterColumn('user', 'password_hash', Schema::TYPE_STRING);
        $this->renameTable('job_ad', 'job');

        $this->dropForeignKey('favourites_jobAd_ref', 'favourites');
        $this->renameColumn('favourites', 'job_ad_id', 'job_id');
        $this->addForeignKey('favourites_job_ref', 'favourites', 'job_id', 'job', 'id');

        $this->dropForeignKey('jobAd_company_ref', 'job');
        $this->addForeignKey('job_company_ref', 'job', 'company_id', 'company', 'id');

        $this->dropForeignKey('jobAd_recruiter_ref', 'job');
        $this->addForeignKey('job_recruiter_ref', 'job', 'contact_id', 'user', 'id');

        $this->dropForeignKey('application_ad_rel', 'application');
        $this->renameColumn('application', 'jobAd_id', 'job_id');
        $this->addForeignKey('application_job_rel', 'application', 'job_id', 'job', 'id');
    }

    public function down()
    {
        echo "m150503_153611_renameTables cannot be reverted.\n";

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
