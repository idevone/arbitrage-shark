<?php

namespace app\controllers;

use app\models\FilterForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\web\Controller;

class MediabuyersController extends Controller
{

    public function actionIndex(): string
    {
        $model = new FilterForm();
        $query = (new Query())
            ->from('audience');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->groupBy === 'campaign_id') {
                $query->select([
                    'campaign_id',
                    'COUNT(*) as count'
                ])->groupBy(['campaign_id']);
            } elseif ($model->groupBy === 'ad_id') {
                $query->select([
                    'ad_id',
                    'COUNT(*) as count'
                ])->groupBy(['ad_id']);
            } elseif ($model->groupBy === 'created_at') {
                $query->select([
                    'TO_CHAR(created_at, \'DD-MM-YYYY\') as created_at',
                    'COUNT(*) as count'
                ])->groupBy(['created_at']);
            }

            // Фильтрация по дате, если она указана
            if ($model->startDate && $model->endDate) {
                $query->andWhere(['between', 'created_at', $model->startDate, $model->endDate]);
            }
        } else {
            // Если форма не была загружена или валидирована, выбираем все записи
            $query->select([
                'campaign_id',
                'ad_id',
                'TO_CHAR(created_at, \'DD-MM-YYYY\') as created_at',
                'COUNT(*) as count'
            ])->groupBy(['campaign_id', 'ad_id', 'created_at']);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBuyers()
    {
        return $this->render('buyers');
    }

}