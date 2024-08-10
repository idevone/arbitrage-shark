<?php

namespace app\components;

use yii\bootstrap5\Html;
use yii\bootstrap5\Widget;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\widgets\Pjax;

class UsersGridView extends Widget
{
    public $role;

    public function run()
    {
        if ($this->role === 'All') {
            $dataProvider = new ActiveDataProvider([
                'query' => \app\models\User::find(),
            ]);
        } else {
            $dataProvider = new ActiveDataProvider([
                'query' => \app\models\User::find()->where(['role' => $this->role]),
            ]);
        }

        Pjax::begin();
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'username',
                    'label' => 'Имя пользователя',
                ],
                [
                    'label' => 'Роль пользователя',
                    'attribute' => 'role',
                    'format' => 'html',
                    'value' => function ($model) {
                        return BadgeHelper::getRoleBadge($model->role);
                    },
                ],
                [
                    'label' => 'Статус пользователя',
                    'attribute' => 'status',
                    'format' => 'html',
                    'value' => function ($model) {
                        return BadgeHelper::getStatusBadge($model->status);
                    },
                ],
                [
                    'label' => 'Дата создания',
                    'attribute' => 'created_at',
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
                    'attribute' => 'Деактивировать',
                    'format' => 'html',
                    'value' => function ($model) {
                        return Html::a('Деактивировать', ['users/deactivate', 'id' => $model->id], ['class' => 'btn btn-danger']);
                    },
                    'headerOptions' => ['class' => 'status-header cursor-pointer mw-100 text-primary'],
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
            'tableOptions' => [
                'class' => 'table table-striped table-hover',

            ],

        ]);
        Pjax::end();
    }
}