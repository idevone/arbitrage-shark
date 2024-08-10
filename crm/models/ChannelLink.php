<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class ChannelLink extends ActiveRecord
{
    public static function tableName()
    {
        return 'channel_links';
    }

//    public function rules()
//    {
//        return [
//            [['channel_id', 'unique_id', 'link'], 'required'],
//            [['channel_id'], 'integer'],
//            [['link'], 'string'],
//            [['created_at'], 'safe'],
//            [['unique_id'], 'string', 'max' => 255],
//        ];
//    }

    public function generateUniqueId(): string
    {
        return bin2hex(random_bytes(4)); // Генерация 8-символьного уникального идентификатора
    }

    public function createLink($channel_id, $params)
    {
        $this->channel_id = $channel_id;
        $this->unique_id = $this->generateUniqueId();
        $query = http_build_query($params);
        $this->link = "/c/{$this->unique_id}?{$query}";
        return $this->save();
    }
}
