<?php

use app\components\FinancialCardView;
use app\components\FinancialGridView;
use yii\grid\GridView;
use yii\widgets\Pjax;
?>



<?php
echo FinancialCardView::widget(['date' => 'all']);
echo FinancialGridView::widget(['date' => 'all']);