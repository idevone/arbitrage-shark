<?php

use yii\bootstrap5\Modal;
use yii\bootstrap5\Tabs;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Facebook Pixels';
?>

<div class="users-index mt-5">
    <h1><?= Html::encode($this->title) ?></h1>

    <p class="mt-5">
        <?= Html::button('Добавить новый пиксель', ['value' => \yii\helpers\Url::to(['pixel/create']), 'class' => 'btn btn-primary', 'id' => 'modalButton']) ?>
    </p>

    <?php $tabItems = [
        [
            'label' => 'Мои пиксели',
            'content' => $this->render('_my'),
            'active' => true,
        ],
    ];

    if (Yii::$app->user->identity->role == 'Admin') {
        $tabItems[] = [
            'label' => 'Все пиксели',
            'content' => $this->render('_all'),
        ];
    }
    echo Tabs::widget([
        'items' => $tabItems,

    ]); ?>

    <?php
    Modal::begin([
        'title' => '<h4>Добавление нового Pixel</h4>',
        'id' => 'modal',
        'size' => 'modal-lg',
    ]);

    echo "<div id='modalContent'>";
    $this->render('create', ['model' => new \app\models\Pixel()]);
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