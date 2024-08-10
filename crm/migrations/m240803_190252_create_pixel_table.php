<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pixel}}`.
 */
class m240803_190252_create_pixel_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pixel}}', [
            'id' => $this->primaryKey(),
            'owner' => $this->string()->notNull(),
            'channel' => $this->string()->null(),
            'pixel_id' => $this->string()->null(),
            'pixel_api' => $this->string()->notNull(),
            'created_at' => $this->string()->notNull(),
            'updated_at' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%pixel}}');
    }
}
