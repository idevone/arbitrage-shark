<?php

namespace app\models;

use yii\db\ActiveRecord;

class TrafficData extends ActiveRecord
{
    public static function tableName()
    {
        return 'audience';
    }

}