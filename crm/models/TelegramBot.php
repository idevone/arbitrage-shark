<?php

namespace app\models;

use yii\db\ActiveRecord;


/**
 * TelegramBot model
 * @property integer $id
 * @property string $bot_name
 * @property string $bot_id
 * @property string $bot_token
 * @property string $channel_id
 * @property string $created_at
 * @property string $updated_at
 */



class TelegramBot extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%channel_bots}}';
    }

    public function getChannelId()
    {
        return $this->hasOne(ChannelForm::class, ['channel_id' => 'channel_id']);
    }
}