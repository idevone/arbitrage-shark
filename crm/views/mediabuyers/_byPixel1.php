<?php
use app\models\TrafficData;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;

$query = TrafficData::find()
    ->select([
        'pixel_id',
//        'COUNT(fbclid) AS unique_fbclid_count',
        'COUNT(DISTINCT user_id) AS unique_user_id_count',
    ])
    ->where(['not', ['user_id' => null]])
    ->groupBy('pixel_id')
    ->asArray()
    ->all();

$dataProvider = new ArrayDataProvider([
    'allModels' => $query,
    'pagination' => [
        'pageSize' => 20,
    ],
]);

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => 'Итог: {totalCount} записей',
    'columns' => [
        ['label' => 'Pixel', 'value' => function ($data) {
            $dataPixel = \app\models\Pixel::find()
                ->where(['pixel_id' => $data['pixel_id']])
                ->one();
            if ($dataPixel !== null) {
                return $dataPixel->pixel_title;
            }
            return $data['pixel_id'];
        }],
        ['attribute' => 'unique_fbclid_count', 'label' => 'Клики', 'value' => function($data) {
            return \app\models\TrafficData::find()
                ->where(['pixel_id' => $data['pixel_id']])
                ->andWhere(['not', ['fbclid' => null]])
                ->count();
        }],
        ['attribute' => 'unique_user_id_count', 'label' => 'Подписчиков'],
        ['attribute' => 'unique_user_id_count', 'label' => 'Диалогов', 'value' => function() {
            return \app\models\TrafficData::find()
                ->where(['status' => 'Contact'])
                ->count();
        }],
        ['attribute' => 'unique_user_id_count', 'label' => 'Депозитов', 'value' => function() {
            return \app\models\TrafficData::find()
                ->where(['status' => 'Purchase'])
                ->count();
        }],
    ],
]);