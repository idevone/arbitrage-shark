<?php
use app\models\TrafficData;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;

// Замените на имя вашей модели

$query = TrafficData::find()
    ->select([
        'channel',
        'COUNT(DISTINCT fbclid) AS unique_fbclid_count',
        'COUNT(DISTINCT user_id) AS unique_user_id_count',
    ])
    ->groupBy('channel')
    ->asArray()
    ->all();

$dataProvider = new ArrayDataProvider([
    'allModels' => $query, // Используем результаты запроса с ActiveRecord
    'pagination' => [
        'pageSize' => 99999,
    ],
]);

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => 'Итог: {totalCount} записей',
    'columns' => [
        ['attribute' => 'channel', 'label' => 'Канал'],
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