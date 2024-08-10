<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m240802_145226_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey()->comment('ID'),
            'username' => $this->string()->notNull()->unique()->comment('Username') ?? 'dev',
            'password' => $this->string()->notNull()->comment('Password'),
            'authKey' => $this->string(32)->null()->comment('Auth key'),
            'accessToken' => $this->string(32)->null()->comment('Access token'),
            'role' => $this->string()->notNull()->comment('Role') ?? 'Mediabuyer',
            'telegram_accounts' => $this->string()->null()->comment('Telegram accounts'),
            'status' => $this->string()->null()->comment('Status') ?? 'active',
            'created_at' => $this->dateTime()->notNull()->comment('Created at'),
            'updated_at' => $this->dateTime()->notNull()->comment('Updated at'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
