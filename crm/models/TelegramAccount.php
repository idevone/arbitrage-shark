<?php

namespace app\models;

use yii\db\ActiveRecord;

class TelegramAccount extends ActiveRecord
{
    public $phone;
    public $code;
    public $step = 'phone';
    public $password;

    public static function tableName(): string
    {
        return '{{%telegram_account}}';
    }

//    public function rules()
//    {
//        return [
//            [['phone'], 'required', 'when' => function ($model) {
//                return $model->step === 'phone';
//            }, 'whenClient' => "function (attribute, value) {
//                return $('#telegramauthform-step').val() === 'phone';
//            }"],
//            [['code'], 'required', 'when' => function ($model) {
//                return $model->step === 'code';
//            }, 'whenClient' => "function (attribute, value) {
//                return $('#telegramauthform-step').val() === 'code';
//            }"],
//            [['password'], 'safe'],
//        ];
//    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'phone' => 'Phone',
            'api_id' => 'API ID',
            'api_hash' => 'API Hash',
            'code' => 'Code',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}