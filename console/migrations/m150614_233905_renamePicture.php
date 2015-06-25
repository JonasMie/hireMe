<?php

use yii\db\Schema;
use yii\db\Migration;

class m150614_233905_renamePicture extends Migration
{
    public function up()
    {
        $this->dropForeignKey('picture_user_ref', 'user');
        $this->renameColumn('user', 'picture', 'picture_id');
        $this->addForeignKey('picture_user_ref', 'user', 'picture_id', 'file', 'id');
    }

    public function down()
    {
        echo "m150614_233905_renamePicture cannot be reverted.\n";

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
