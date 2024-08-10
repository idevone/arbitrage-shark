<?php

use app\models\TelegramAccount;
use yii\bootstrap5\Modal;
use yii\bootstrap5\Tabs;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Telegram аккаунты';
?>
<div class="accounts-index mt-5">
    <h1><?= Html::encode($this->title) ?></h1>

    <p class="mt-5">
        <?= Html::button('Добавить новый аккаунт', ['value' => \yii\helpers\Url::to(['accounts/create']), 'class' => 'btn btn-primary', 'id' => 'modalButton']) ?>
    </p>


    <?= Tabs::widget([
        'items' => [
            [
                'label' => 'Все telegram аккаунты',
                'content' => $this->render('_all'),
                'active' => true,
            ],
            [
                'label' => 'Активные',
                'content' => $this->render('_all'),
            ],
            [
                'label' => 'Неактивные',
                'content' => $this->render('_all'),
            ],
            [
                'label' => 'Заблокированные',
                'content' => $this->render('_all'),
            ],
        ],
    ]) ?>


    <?php
    Modal::begin([
        'title' => '<h4>Добавление нового Telegram аккаунта</h4>',
        'id' => 'modal',
        'size' => 'modal-lg',
    ]);

    echo "<div id='modalContent'>";
//    $this->render('create', ['model' => new TelegramAccount()]);
    echo "</div>";

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