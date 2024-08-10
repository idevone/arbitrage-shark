<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%telegram_channel}}`.
 */
class m240802_170735_create_telegram_channel_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%telegram_channel}}', [
            'id' => $this->primaryKey(),
            'channel_id' => $this->string()->notNull()->unique()->comment('Channel ID') ?? 'Not set',
            'channel_name' => $this->string()->notNull()->unique()->comment('Channel name') ?? 'Not set',
            'channel_bot' => $this->string()->null()->unique()->comment('Channel bot') ?? 'Not set',
            'responsible' => $this->string()->null()->comment('Users for channels') ?? 'Not set',
            'invite_link' => $this->string()->null()->unique()->comment('Invite link') ?? 'Not set',
            'fb_pixel' => $this->string()->null()->unique()->comment('Facebook pixel') ?? 'Not set',
            'telegram_account' => $this->string()->null()->comment('Telegram account') ?? 'Not set',
            'created_at' => $this->dateTime()->notNull()->comment('Created at'),
            'updated_at' => $this->dateTime()->notNull()->comment('Updated at'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%telegram_channel}}');
    }
}
