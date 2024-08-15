<?php

namespace app\components;

use Yii;
use Codeception\Module\Yii2;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\bootstrap5\Widget;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\widgets\Pjax;

class ChannelsGridView extends Widget
{
    public $owner;

    public function run()
    {

        if ($this->owner === 'All') {
            $dataProvider = new ActiveDataProvider([
                'query' => \app\models\ChannelForm::find(),
            ]);
        } else {
            $dataProvider = new ActiveDataProvider([
                'query' => \app\models\ChannelForm::find()->where(['owner' => Yii::$app->user->identity->username]),
            ]);
        }

        Pjax::begin();
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'channel_name',
                    'label' => 'Название канала',
                ],
                [
                    'attribute' => 'channel_id',
                    'label' => 'ID канала',
                ],
                [
                    'attribute' => 'fb_pixel',
                    'label' => 'ID пикселя',
                    'value' => function ($model) {
                        if (!empty($model->fb_pixel)) {
                            return Html::encode(substr($model->fb_pixel, 0, 5) . '...' . substr($model->fb_pixel, -5));
                        } else {
                            return 'Пиксель не назначен';
                        }
                    },
                ],
                [
                    'attribute' => 'telegram_account',
                    'label' => 'Аккаунт телеграм',
                ],
//                [
//                    'attribute' => 'channel_bot',
//                    'label' => 'Токен бота',
//                    'value' => function ($model) {
//                        return Html::encode(substr($model->channel_bot, 0, 5) . '...' . substr($model->channel_bot, -5));
//                    },
//                ],
//                [
//                    'attribute' => 'btn_link',
//                    'label' => 'Ссылка на кнопку',
//                    'value' => function ($model) {
//                        return Html::encode(substr($model->btn_link, 0, 5) . '...' . substr($model->btn_link, -5));
//                    },
//                ],
                [
                    'attribute' => 'created_at',
                    'label' => 'Дата создания',
                    'format' => 'html',
                    'value' => function ($model) {
                        if (!empty($model->created_at)) {
                            $timestamp = strtotime($model->created_at);
                            return date('D-y-m H:i:s', $timestamp);
                        } else {
                            return 'Дата не указана';
                        }
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{copy} {update} {delete}',
                    'buttons' => [
                        'copy' => function ($url, $model, $key) {
                            return Html::button('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard" viewBox="0 0 16 16">
  <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z"/>
  <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z"/>
</svg>', [
                                'class' => 'btn btn-primary',
                                'data-link' => $model->btn_link,
                                'onclick' => 'copyLink(this.getAttribute("data-link"))',
                            ]);
                        },
                        'update' => function ($url, $model, $key) {
                            return Html::button('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16"><path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/><path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/></svg>', [
                                'class' => 'btn btn-warning modalButtonUpdate',
                                'value' => Url::to(['channels/update', 'id' => $model->id]),
                            ]);
                        },
                        'delete' => function ($url, $model, $key) {
                            return Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/><path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/></svg>', $url, ['class' => 'btn btn-danger']);
                        },
                    ],
                ],
            ],
            'tableOptions' => [
                'class' => 'table table-striped table-hover',
            ],
        ]);
        Pjax::end();
    }
}

