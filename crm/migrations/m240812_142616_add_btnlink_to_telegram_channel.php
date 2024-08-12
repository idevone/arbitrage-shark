<?php

use yii\db\Migration;

/**
 * Class m240812_142616_add_btnlink_to_telegram_channel
 */
class m240812_142616_add_btnlink_to_telegram_channel extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%telegram_channel}}', 'btn_link', $this->text()->after('id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%telegram_channel}}', 'btn_link');
    }
}
