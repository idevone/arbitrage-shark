<?php
use app\models\TrafficData;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;

// Замените на имя вашей модели

$query = TrafficData::find()
    ->select([
        'created_at',
        'COUNT(DISTINCT fbclid) AS unique_fbclid_count',
        'COUNT(DISTINCT user_id) AS unique_user_id_count',
        'COUNT(fbclid) AS fbclid_count',
    ])
    ->groupBy('created_at')
    ->asArray()
    ->all();

$dataProvider = new ArrayDataProvider([
    'allModels' => $query,
    'pagination' => [
        'pageSize' => 999999,
    ],
]);

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => 'Итог: {totalCount} записей',
    'columns' => [
        ['attribute' => 'created_at', 'label' => 'Дата', 'format' => ['date', 'php:d.m.Y H:i:s']],
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
