<?php

namespace app\models;

use yii\db\ActiveRecord;

class FinancialRecordForm extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%financial}}';
    }

    public function rules(): array
    {
        return [
            [['amount', 'purpose'], 'required'],
            [['amount'], 'number'],
            [['purpose'], 'string'],
        ];
    }
}