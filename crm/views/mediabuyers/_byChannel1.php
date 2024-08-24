<?php
use app\models\TrafficData;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;

// Замените на имя вашей модели

$query = TrafficData::find()
    ->select([
        'channel_name',
        'COUNT(DISTINCT fbclid) AS unique_fbclid_count',
        'COUNT(DISTINCT user_id) AS unique_user_id_count',
    ])
    ->groupBy('channel_name')
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
        ['attribute' => 'channel_name', 'label' => 'Канал'],
        ['attribute' => 'unique_fbclid_count', 'label' => 'Клики'],
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