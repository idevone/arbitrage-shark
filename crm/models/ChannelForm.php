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
 * @property string $responsible
 * @property string $invite_link
 * @property string $fb_pixel
 * @property string $telegram_account
 * @property string $created_at
 * @property string $updated_at
 */

class ChannelForm extends ActiveRecord
{
    public array $selectedPixels = [];

    public static function tableName(): string
    {
        return '{{%telegram_channel}}';
    }

//    public function rules()
//    {
//        return [
//            [['created_at', 'updated_at'], 'required'],
//            [['created_at', 'updated_at'], 'safe'],
//        ];
//    }
}