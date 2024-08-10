<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Modal;
use yii\bootstrap5\Tabs;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Пользователи системы';
$dataProvider = new \yii\data\ActiveDataProvider([
    'query' => \app\models\User::find(),
]);
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="users-index mt-5">
    <h1><?= Html::encode($this->title) ?></h1>

    <p class="mt-5">
        <?= Html::button('Добавить нового пользователя', ['value' => \yii\helpers\Url::to(['users/create']), 'class' => 'btn btn-primary', 'id' => 'modalButton']) ?>
    </p>

    <?= Tabs::widget([
        'items' => [
            [
                'label' => 'Все пользователи',
                'content' => $this->render('_users'),
                'active' => true,
            ],
            [
                'label' => 'Финансисты',
                'content' => $this->render('_financials'),
            ],
            [
                'label' => 'Тимлиды обработчиков',
                'content' => $this->render('_teamleadsprocessors'),
            ],
            [
                'label' => 'Тимлиды медиабайеров',
                'content' => $this->render('_teamleadsmediabuyers'),
            ],
            [
                'label' => 'Медиабайеры',
                'content' => $this->render('_mediabuyers'),
            ],
            [
                'label' => 'Обработчики',
                'content' => $this->render('_processors'),
            ],
            [
                'label' => 'Администраторы',
                'content' => $this->render('_admins'),
            ],
        ],
    ]) ?>

    <?php
    Modal::begin([
        'title' => '<h4>Добавление нового пользователя</h4>',
        'id' => 'modal',
        'size' => 'modal-lg',
    ]);

    echo "<div id='modalContent'>";
    $this->render('create', ['model' => new \app\models\User()]);
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