<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%telegram_account}}`.
 */
class m240802_165345_create_telegram_account_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%telegram_account}}', [
            'id' => $this->primaryKey()->comment('ID'),
            'user_id' => $this->string()->notNull()->unique()->comment('User ID'),
            'username' => $this->string()->null()->comment('Username'),
            'first_name' => $this->string()->null()->comment('First name'),
            'last_name' => $this->string()->null()->comment('Last name'),
            'responsible' => $this->string()->null()->comment('Users for accounts') ?? 'Not set',
            'phone_number' => $this->string()->notNull()->unique()->comment('Phone number'),
            'status' => $this->string()->notNull()->comment('Status') ?? 'Unverified',
            'api_id' => $this->string()->notNull()->unique()->comment('API ID'),
            'api_hash' => $this->string()->notNull()->unique()->comment('API hash'),
            'session_string' => $this->string()->null()->unique()->comment('Session string'),
            'created_at' => $this->dateTime()->notNull()->comment('Created at'),
            'updated_at' => $this->dateTime()->notNull()->comment('Updated at'),
        ]);

        $this->createIndex(
            '{{%idx-telegram_account-responsible}}',
            '{{%telegram_account}}',
            'responsible'
        );

        $this->addForeignKey(
            '{{%fk-telegram_account-responsible}}',
            '{{%telegram_account}}',
            'responsible',
            '{{%user}}',
            'username',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%telegram_account}}');
    }
}
