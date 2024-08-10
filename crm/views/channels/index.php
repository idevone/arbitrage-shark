<?php

use app\components\ChannelsGridView;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Telegram каналы';
?>
<div class="users-index mt-5">
    <h1><?= Html::encode($this->title) ?></h1>

    <p class="mt-5">
        <?= Html::button('Добавить новый канал', ['value' => Url::to(['channels/create']), 'class' => 'btn btn-primary', 'id' => 'modalButtonCreate']) ?>
    </p>

    <?php
    echo ChannelsGridView::widget(['owner' => 'All']);

    // Определяем одно модальное окно для создания и обновления
    Modal::begin([
        'title' => '<h4>Операция</h4>',
        'id' => 'modal',
        'size' => 'modal-lg',
    ]);

    echo "<div id='modalContent'></div>";

    Modal::end();

    $script = <<< JS
        $(function() {
            // Открытие модального окна для создания новой записи
            $('#modalButtonCreate').click(function() {
                $('#modal').modal('show')
                    .find('#modalContent')
                    .load($(this).attr('value'));
            });

            // Открытие модального окна для обновления записи
            $(document).on('click', '.modalButtonUpdate', function() {
                $('#modal').modal('show')
                    .find('#modalContent')
                    .load($(this).attr('value'));
            });
        });
    JS;
    $this->registerJs($script);
    ?>
</div>
