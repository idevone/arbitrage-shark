<?php

use yii\db\Migration;

/**
 * Class m240814_173337_update_audience_table
 */
class m240814_173337_update_audience_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%audience}}', 'created_at', $this->string()->null()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240814_173337_update_audience_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240814_173337_update_audience_table cannot be reverted.\n";

        return false;
    }
    */
}
