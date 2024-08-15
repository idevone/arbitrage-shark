<?php

use yii\db\Migration;

/**
 * Class m240812_141630_add_hashd_to_telegram_channel
 */
class m240812_141630_add_hashd_to_telegram_channel extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%audience}}', 'status', $this->string()->null()->unique()->after('id'));
        $this->alterColumn('{{%audience}}', 'user_id', $this->string()->null()->unique());
        $this->alterColumn('{{%audience}}', 'user_name', $this->string()->null()->unique());
        $this->alterColumn('{{%audience}}', 'placement', $this->string()->null()->unique());
        $this->alterColumn('{{%audience}}', 'site_source_name', $this->string()->null()->unique());
        $this->alterColumn('{{%audience}}', 'ad_id', $this->string()->null()->unique());
        $this->alterColumn('{{%audience}}', 'ad_name', $this->string()->null()->unique());
        $this->alterColumn('{{%audience}}', 'adset_id', $this->string()->null()->unique());
        $this->alterColumn('{{%audience}}', 'adset_name', $this->string()->null()->unique());
        $this->alterColumn('{{%audience}}', 'campaign_id', $this->string()->null()->unique());
        $this->alterColumn('{{%audience}}', 'campaign_name', $this->string()->null()->unique());
        $this->alterColumn('{{%audience}}', 'fbclid', $this->string()->null()->unique());
        $this->alterColumn('{{%audience}}', 'created_at', $this->dateTime()->null()->unique() ?? 'CURRENT_TIMESTAMP');
        $this->alterColumn('{{%audience}}', 'updated_at', $this->dateTime()->null()->unique() ?? 'CURRENT_TIMESTAMP');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%telegram_channel}}', 'hashId');
    }
}
