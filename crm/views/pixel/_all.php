<?php

use app\components\PixelsGridView;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\components\UsersGridView;

echo PixelsGridView::widget(['owner' => 'All']);