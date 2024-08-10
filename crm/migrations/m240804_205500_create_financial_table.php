<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%financial}}`.
 */
class m240804_205500_create_financial_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%financial}}', [
            'id' => $this->primaryKey(),
            'amount' => $this->decimal(10, 2)->notNull(),
            'purpose' => $this->string()->notNull(),
            'financier' => $this->string()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%financial}}');
    }
}
