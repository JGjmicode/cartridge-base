<?php

use yii\db\Migration;

class m170210_083229_create_repairs_table extends Migration
{
    public function up()
    {
        $this->createTable('repairs', [
            'id' => $this->primaryKey(),
            'model' => $this->string(128)->notNull(),
            'invNumber' => $this->string(20)->notNull(),
            'cabinet' => $this->string(8),
            'problem' => $this->text()->notNull(),
            'note' => $this->text()
        ]);
    }

    public function down()
    {
        $this->dropTable('repairs');
    }
}
