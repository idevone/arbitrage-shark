<?php
use app\models\TrafficData;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;

// Замените на имя вашей модели

$query = TrafficData::find()
    ->select([
        'pixel_id',
        'COUNT(DISTINCT fbclid) AS unique_fbclid_count',
        'COUNT(DISTINCT user_id) AS unique_user_id_count',
    ])
    ->groupBy('pixel_id')
    ->asArray()
    ->all();

$dataProvider = new ArrayDataProvider([
    'allModels' => $query, // Используем результаты запроса с ActiveRecord
    'pagination' => [
        'pageSize' => 20,
    ],
]);

$data = [
    ['pixel_id' => "SportChannel - AnatoliyBuyer"],
    ['pixel_id' => "SportChannel - EvgeniyBuyer"],
    ['pixel_id' => "SportChannel - AlexeyBuyer"],
    ['pixel_id' => "SportChannel - IvanBuyer"],
    ['pixel_id' => "SportChannel - NikolayBuyer"],

];

//$dataProvider = new \yii\data\ArrayDataProvider([
//    'pixel_id' => $data,
//]);

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => 'Итог: {totalCount} записей',
    'columns' => [
        ['label' => 'Pixel ID', 'value' => function ($data) {
            if ($data['pixel_id'] == '358179124053246') {
                return 'Aurora';
            } elseif ($data['pixel_id'] == '3679089882347512') {
                return 'Diego';
            } elseif ($data['pixel_id'] == '') {
                return 'Laura';
            } elseif ($data['pixel_id'] == 'SportChannel - AlexeyBuyer') {
                return 'Mariana';
            } elseif ($data['pixel_id'] == '453198644365580') {
                return 'Jessica';
            } elseif ($data['pixel_id'] == '509725885041613') {
                return 'Jessica';
            } else {
                return "Jessica";
            }
        }],
        ['attribute' => 'unique_fbclid_count', 'label' => 'Кликов'],
        ['attribute' => 'unique_user_id_count', 'label' => 'Подписчиков'],
        ['label' => 'Диалогов', 'value' => function ($data) {
            return 0;
        }],
        ['label' => 'Депозитов', 'value' => function ($data) {
            return 0;
        }],
    ],
]);