<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * ChannelForm model
 *
 * @property integer $id
 * @property string $channel_id
 * @property string $channel_name
 * @property string $channel_bot
 * @property string $fb_pixel
 * @property string $telegram_account
 * @property string $created_at
 * @property string $updated_at
 * @property array $selectedPixels
 * @property string $hashId
 * @property string $btn_link
 */

class ChannelForm extends ActiveRecord
{
    public array $selectedPixels = [];

    public static function tableName(): string
    {
        return '{{%telegram_channel}}';
    }

    public function getBot()
    {
        return $this->hasOne(TelegramBot::class, ['channel_id' => 'channel_id']);
    }
//    public function rules()
//    {
//        return [
//            [['created_at', 'updated_at'], 'required'],
//            [['created_at', 'updated_at'], 'safe'],
//        ];
//    }
}