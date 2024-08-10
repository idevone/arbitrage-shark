<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%roles}}`.
 */
class m240802_172039_create_roles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%roles}}', [
            'id' => $this->primaryKey(),
            'role' => $this->string()->notNull()->unique()->comment('Role'),
            'created_at' => $this->dateTime()->notNull()->comment('Created at'),
            'updated_at' => $this->dateTime()->notNull()->comment('Updated at'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%roles}}');
    }
}
