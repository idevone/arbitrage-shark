<?php

use yii\bootstrap5\Modal;
use yii\bootstrap5\Tabs;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Финансовая статистика';
?>
<div class="users-index mt-5">
    <h1><?= Html::encode($this->title) ?></h1>

    <p class="mt-5">
        <?= Html::button('Добавить новый платеж', ['value' => Url::to(['financial/create']), 'class' => 'btn btn-primary', 'id' => 'modalButton']) ?>
    </p>

    <?= Tabs::widget([
        'items' => [
            [
                'label' => 'За последние 24 часа',
                'content' => $this->render('_last24h'),
                'active' => true,
            ],
            [
                'label' => 'За последние 7 дней',
                'content' => $this->render('_last7d'),
            ],
            [
                'label' => 'За последние 30 дней',
                'content' => $this->render('_last30d'),
            ],
            [
                'label' => 'За последние 90 дней',
                'content' => $this->render('_last90d'),
            ],
            [
                'label' => 'За последние 180 дней',
                'content' => $this->render('_last180d'),
            ],
            [
                'label' => 'За последний год',
                'content' => $this->render('_lastYear'),
            ],
            [
                'label' => 'За все время',
                'content' => $this->render('_allTime'),
            ],
            [
                'label' => 'Выбрать период',
                'content' => $this->render('_allTime'),
            ],
        ],
    ]) ?>

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