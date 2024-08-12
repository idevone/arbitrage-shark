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
        <h1>Моя статистика</h1>
        <?php
    } else {
        ?>
        <h1>Ваша статистика</h1>
        <?php
    }
    ?>
    <!--    <p class="mt-5">-->
    <!--        --><?php //= Html::button('Подать новый отчет', ['value' => Url::to(['financial/create']), 'class' => 'btn btn-primary', 'id' => 'modalButton']) ?>
    <!--    </p>-->


    <?= Tabs::widget([
        'items' => [
            [
                'label' => 'По пикселям',
                'content' => $this->render('_byPixel1'),
                'active' => true,
            ],
            [
                'label' => 'По адсетам',
                'content' => $this->render('_byAdset1'),
            ],
            [
                'label' => 'По местам размещения',
                'content' => $this->render('_byPlacement1'),
            ],
            [
                'label' => 'По датам',
                'content' => $this->render('_byDate1'),
            ]
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