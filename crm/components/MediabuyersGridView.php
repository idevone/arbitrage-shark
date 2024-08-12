<?php

namespace app\components;

use app\models\TrafficData;
use Yii;
use yii\base\Widget;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\widgets\Pjax;

class MediabuyersGridView extends Widget
{
    public function run()
    {

        $query = TrafficData::find()
            ->select([
                'created_at',
                'pixel_id',
                'adset_name',
                'campaign_name',
                'ad_name',
                'placement',
            ])
            ->groupBy([
                'created_at',
                'pixel_id',
                'adset_name',
                'campaign_name',
                'ad_name',
                'placement',
            ]);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 999999, // Вы можете указать нужное количество записей на странице
            ],
        ]);

        ob_start();
        Pjax::begin();

        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'summary' => 'Итог: {totalCount} записей',
            'columns' => [
//                ['attribute' => 'created_at', 'label' => 'Дата'],
//                ['attribute' => 'pixel_id', 'label' => 'Канал'],
//                ['attribute' => 'adset_name', 'label' => 'Название адсета'],
//                ['attribute' => 'campaign_name', 'label' => 'Название кампании'],
//                ['attribute' => 'ad_name', 'label' => 'Название объявления'],
                ['label' => 'Группировка', 'value' => function ($model) {
                    return "";
                }],
                ['attribute' => 'placement', 'label' => 'Место размещения'],
                ['attribute' => 'total_clicks', 'label' => 'Кол-во кликов'],
                ['attribute' => 'total_subscribers', 'label' => 'Кол-во подписчиков'],
                ['attribute' => 'total_dialogs', 'label' => 'Кол-во диалогов'],
                ['attribute' => 'total_deposits', 'label' => 'Кол-во депозитов'],
            ],
        ]);

        Pjax::end();
        return ob_get_clean();
    }
}
