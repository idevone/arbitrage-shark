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
        'COUNT(fbclid) AS fbclid_count',
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

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => 'Итог: {totalCount} записей',
    'columns' => [
        ['attribute' => 'pixel_id', 'label' => 'Pixel ID'],
        ['attribute' => 'unique_fbclid_count', 'label' => 'Unique FBCLIDs'],
        ['attribute' => 'unique_user_id_count', 'label' => 'Подписчиков'],
        ['attribute' => 'fbclid_count', 'label' => 'Всего FBCLIDs'],
    ],
]);