<?php

namespace app\models;

use yii\base\Model;

class FilterForm extends Model
{
    public $groupBy;
    public $channel_name;
    public $pixel_id;
    public $ad_set;
    public $startDate;
    public $endDate;

    public function rules()
    {
        return [
            [['groupBy', 'channel_name', 'pixel_id', 'ad_set'], 'string'],
            [['startDate', 'endDate'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }
}