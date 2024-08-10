<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use app\components\UsersGridView;

echo UsersGridView::widget(['role' => 'TeamLeadProcessor']);