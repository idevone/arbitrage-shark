<?php

namespace app\models;

use yii\base\Model;

class TelegramAuthForm extends Model
{
    public $phone;
    public $code;
    public $step = 'phone';
    public $password;

    public function rules()
    {
        return [
            [['phone'], 'required', 'when' => function ($model) {
                return $model->step === 'phone';
            }, 'whenClient' => "function (attribute, value) {
return $('#telegramauthform-step').val() === 'phone';
}"],
            [['code'], 'required', 'when' => function ($model) {
                return $model->step === 'code';
            }, 'whenClient' => "function (attribute, value) {
return $('#telegramauthform-step').val() === 'code';
}"],
            [['password'], 'safe'],
        ];
    }
}
