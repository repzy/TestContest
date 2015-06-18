<?php

use yii\db\Schema;
use yii\db\Migration;

class m150616_220141_authors extends Migration
{
    public function up()
    {
        $this->createTable('authors', [
            'id' => Schema::TYPE_PK,
            'ip' => Schema::TYPE_INTEGER . ' NOT NULL',
            'browser' => Schema::TYPE_STRING . ' NOT NULL',
            'country' => Schema::TYPE_STRING . ' NOT NULL',
        ]);
    }

    public function down()
    {
        $this->dropTable('authors');
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
