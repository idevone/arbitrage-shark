<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%audience}}`.
 */
class m240814_170718_create_audience_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%audience}}', [
            'id' => $this->primaryKey()->comment('По совместительству Event ID в Facebook'),
            'pixel_id' => $this->string()->notNull()->comment('ID пикселя'),
            'status' => $this->string()->notNull()->comment('Статус Subscribed/Contact/Purchased'),
            'user_id' => $this->string()->notNull()->comment('Telegram ID пользователя'),
            'user_name' => $this->string()->notNull()->comment('Имя пользователя'),
            'chat_id' => $this->string()->notNull()->comment('ID чата'),
            'placement' => $this->string()->notNull()->comment('Место размещения пикселя'),
            'site_source_name' => $this->string()->notNull()->comment('Источник сайта'),
            'ad_id' => $this->string()->notNull()->comment('ID рекламы'),
            'ad_name' => $this->string()->notNull()->comment('Название рекламы'),
            'adset_id' => $this->string()->notNull()->comment('ID набора рекламы'),
            'adset_name' => $this->string()->notNull()->comment('Название набора рекламы'),
            'campaign_id' => $this->string()->notNull()->comment('ID кампании'),
            'campaign_name' => $this->string()->notNull()->comment('Название кампании'),
            'fbclid' => $this->string()->notNull()->comment('ID fbclid'),
            'created_at' => $this->dateTime()->notNull()->comment('Дата создания'),
            'updated_at' => $this->dateTime()->notNull()->comment('Дата обновления'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%audience}}');
    }
}
