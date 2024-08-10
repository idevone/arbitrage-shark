<?php

use yii\db\Migration;

class m240809_191116_alter_username_column_in_user_table extends Migration
{
    public function safeUp()
    {
        // Изменение параметров столбца
        $this->alterColumn('user', 'created_at', $this->string(150)->null());
        $this->alterColumn('user', 'updated_at', $this->string(150)->null());
    }

    public function safeDown()
    {
        $this->alterColumn('user', 'created_at', $this->string(255)->null());
        $this->alterColumn('user', 'updated_at', $this->string(255)->null());
    }
}
