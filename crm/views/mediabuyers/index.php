<?php

use app\components\MediabuyersGridView;
use yii\bootstrap5\Modal;
use yii\bootstrap5\Tabs;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Медиа статистика';
?>
<div class="users-index mt-5">

    <?php
    if (Yii::$app->user->identity->role === 'Admin' || Yii::$app->user->identity->role === 'TeamLeadMediabuyer') {
        ?>
        <h1>Административная статистика</h1>
        <?php
        echo MediabuyersGridView::widget();
    } else {
    ?>
    <h1>Ваша статистика</h1>
    <?php
    }
    ?>
    <p class="mt-5">
        <?= Html::button('Подать новый отчет', ['value' => Url::to(['financial/create']), 'class' => 'btn btn-primary', 'id' => 'modalButton']) ?>
    </p>


    <!--    --><?php //= Tabs::widget([
    //        'items' => [
    //            [
    //                'label' => 'За последние 24 часа',
    //                'content' => $this->render('_last24h'),
    //                'active' => true,
    //            ],
    //            [
    //                'label' => 'За последние 7 дней',
    //                'content' => $this->render('_last7d'),
    //            ],
    //            [
    //                'label' => 'За последние 30 дней',
    //                'content' => $this->render('_last30d'),
    //            ],
    //            [
    //                'label' => 'За последние 90 дней',
    //                'content' => $this->render('_last90d'),
    //            ],
    //            [
    //                'label' => 'За последние 180 дней',
    //                'content' => $this->render('_last180d'),
    //            ],
    //            [
    //                'label' => 'За последний год',
    //                'content' => $this->render('_lastYear'),
    //            ],
    //            [
    //                'label' => 'За все время',
    //                'content' => $this->render('_allTime'),
    //            ],
    //            [
    //                'label' => 'Выбрать период',
    //                'content' => $this->render('_allTime'),
    //            ],
    //        ],
    //    ]) ?>

    <?php
    Modal::begin([
        'title' => '<h4>Добавление новой записи</h4>',
        'id' => 'modal',
        'size' => 'modal-lg',
    ]);

    echo "<div id='modalContent'>";
    $this->render('create', ['model' => new \app\models\FinancialRecordForm()]);
    echo "</div>";
    ?>

    <?php
    Modal::end();
    ?>
    <?php
    $script = <<< JS
        $(function() {
            $('#modalButton').click(function() {
                $('#modal').modal('show')
                    .find('#modalContent')
                    .load($(this).attr('value'));
            });
        });
        JS;
    $this->registerJs($script);
    ?>
</div>