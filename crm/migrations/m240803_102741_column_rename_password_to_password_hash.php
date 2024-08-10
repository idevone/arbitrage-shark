<?php

use yii\db\Migration;

/**
 * Class m240803_102741_column_rename_password_to_password_hash
 */
class m240803_102741_column_rename_password_to_password_hash extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('user', 'password', 'password_hash');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240803_102741_column_rename_password_to_password_hash cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240803_102741_column_rename_password_to_password_hash cannot be reverted.\n";

        return false;
    }
    */
}
