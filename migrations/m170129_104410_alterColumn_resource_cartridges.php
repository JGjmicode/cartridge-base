<?php

use yii\db\Migration;

class m170129_104410_alterColumn_resource_cartridges extends Migration
{
    public function up()
    {
        $this->alterColumn('cartridges', 'resource', 'integer null');
    }

    public function down()
    {
        echo "m170129_104410_alterColumn_resource_cartridges cannot be reverted.\n";

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
