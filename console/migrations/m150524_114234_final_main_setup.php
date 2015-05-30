<?php

use yii\db\Schema;
use yii\db\Migration;

class m150524_114234_final_main_setup extends Migration
{
    public function up()
    {
        //  new files table
        $this->createTable('file', [
            'id'   => Schema::TYPE_PK,
            'path' => Schema::TYPE_STRING
        ]);

        // changes on user table
        $this->addColumn('user', 'picture', Schema::TYPE_INTEGER);
        $this->addForeignKey('picture_user_ref', 'user', 'picture', 'file', 'id');

        // changes on job table
        $this->addColumn('job', 'type', Schema::TYPE_SMALLINT . ' not null');
        $this->addColumn('job', 'city', Schema::TYPE_STRING . ' not null');
        $this->addColumn('job', 'time', Schema::TYPE_SMALLINT . ' not null');
        $this->addColumn('job', 'allocated', Schema::TYPE_BOOLEAN);

        // changes on resume_job table
        $this->renameTable('resume', 'resume_job');
        $this->addColumn('resume_job', 'report_id', Schema::TYPE_INTEGER);
        $this->addForeignKey('job_report_file_ref', 'resume_job', 'report_id', 'file', 'id');

        // new resume_school table
        $this->createTable('resume_school', [
            'id'         => Schema::TYPE_PK,
            'user_id'    => Schema::TYPE_INTEGER . ' not null',
            'begin'      => Schema::TYPE_DATE . ' not null',
            'end'        => Schema::TYPE_DATE . ' not null',
            'schoolname' => Schema::TYPE_STRING . ' not null',
            'current' => Schema::TYPE_BOOLEAN .' not null',
            'report_id'  => Schema::TYPE_INTEGER
        ]);
        $this->addForeignKey('resumeSchool_user_rel', 'resume_school', 'user_id', 'user', 'id');
        $this->addForeignKey('school_report_file_ref', 'resume_school', 'report_id', 'file', 'id');


        // new additional qualifications table
        $this->createTable('qualification', [
            'id'          => Schema::TYPE_PK,
            'description' => Schema::TYPE_STRING,
            'file'        => Schema::TYPE_INTEGER
        ]);
        $this->addForeignKey('qualification_file_ref', 'qualification', 'file', 'file', 'id');

        // new cover letter table
        $this->createTable('cover', [
            'id'            => Schema::TYPE_PK,
            'title'         => Schema::TYPE_STRING . ' not null',
            'attachment_id' => Schema::TYPE_INTEGER,
            'created_at'    => Schema::TYPE_TIMESTAMP,
        ]);


        $this->addForeignKey('cover_attachment_file_ref', 'cover', 'attachment_id', 'file', 'id');

        // message attachments
        $this->createTable('message_attachments', [
            'id'         => Schema::TYPE_PK,
            'message_id' => Schema::TYPE_INTEGER,
            'file_id'    => Schema::TYPE_INTEGER
        ]);
        $this->addForeignKey('attachments_file_ref', 'message_attachments', 'file_id', 'file', 'id');
        $this->addForeignKey('message_attachments_message_ref', 'message_attachments', 'message_id', 'message', 'id');



    }

    public function down()
    {
        echo "m150524_114234_final_main_setup cannot be reverted.\n";

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
