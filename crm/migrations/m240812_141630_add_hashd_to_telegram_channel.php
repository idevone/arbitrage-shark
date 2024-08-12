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
        $this->addColumn('{{%telegram_channel}}', 'hashId', $this->string(255)->after('id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%telegram_channel}}', 'hashId');
    }
}
