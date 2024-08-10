<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Pixel model
 *
 * @property integer $id
 * @property string $owner
 * @property string $channel
 * @property string $pixel_id
 * @property string $pixel_api
 * @property string $created_at
 * @property string $updated_at
 */

class Pixel extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%pixel}}';
    }

    public function rules(): array
    {
        return [
            [['owner', 'channel', 'pixel_id', 'pixel_api', 'created_at', 'updated_at'], 'required'],
            [['owner', 'channel', 'pixel_id', 'pixel_api', 'created_at', 'updated_at'], 'string', 'max' => 255],
            [['pixel_id', 'pixel_api'], 'unique'],
        ];
    }
}