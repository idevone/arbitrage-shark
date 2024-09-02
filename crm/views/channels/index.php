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

    <?php
    if (Yii::$app->session->hasFlash('success')) {
        echo '<div class="alert alert-success">' . Yii::$app->session->getFlash('success') . '</div>';
    } elseif (Yii::$app->session->hasFlash('error')) {
        echo '<div class="alert alert-danger">' . Yii::$app->session->getFlash('error') . '</div>';
    }
    ?>

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
    <script>
        function copyLink(link) {
            const tempInput = document.createElement('input');
            tempInput.value = link;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            // alert('Ссылка скопирована: ' + link);
        }
    </script>
</div>