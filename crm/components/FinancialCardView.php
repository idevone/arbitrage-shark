<?php

namespace app\components;

use app\models\FinancialRecordForm;
use Yii;
use yii\bootstrap5\Widget;
use yii\data\ActiveDataProvider;

class FinancialCardView extends Widget
{
    public $date;

    public function run()
    {
        switch ($this->date) {
            case 'all':
//                $incoming = new ActiveDataProvider([
//                    'query' => FinancialRecordForm::find()
//                        ->where(['>=', 'created_at', date('Y-m-d H:i:s', strtotime('-24 hours'))])
//                        ->sum('amount'),
//                ]);
                $incoming = 100;
                $expense = (float)FinancialRecordForm::find()
                    ->where(['>=', 'created_at', date('Y-m-d H:i:s', strtotime('-24 hours'))])
                    ->sum('amount');
                $profit = $incoming - $expense;
                break;
            case 'today':
                $dataProvider = new ActiveDataProvider([
                    'query' => FinancialRecordForm::find()
                        ->where(['>=', 'created_at', date('Y-m-d H:i:s', strtotime('-24 hours'))])
                        ->sum('amount'),
                ]);
                break;
            default:
                $incoming = new ActiveDataProvider([
                    'query' => FinancialRecordForm::find()
                        ->where(['>=', 'created_at', date('Y-m-d H:i:s', strtotime('-24 hours'))])
                        ->sum('amount'),
                ]);
        }

        ?>
        <div class="row row-cols-1 row-cols-md-3 mb-3 mt-5 ">
            <div class="col">
                <div class="card mb-4 rounded-3 shadow-sm">
                    <div class="card-header py-3">
                        <h4 class="my-0 fw-normal"> Доходная часть </h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">
                            <?= Yii::$app->formatter->asDecimal($incoming, 2) . ' $' ?>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-4 rounded-3 shadow-sm">
                    <div class="card-header py-3">
                        <h4 class="my-0 fw-normal"> Расходная часть </h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title"><?= Yii::$app->formatter->asDecimal($expense, 2) . ' $' ?></h1>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-4 rounded-3 shadow-sm">
                    <div class="card-header py-3">
                        <h4 class="my-0 fw-normal"> Чистая прибыль </h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">
                            <?= Yii::$app->formatter->asDecimal($profit, 2) . ' $' ?>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

?>