<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\Pixel $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Создание нового pixel';
?>
<div class="pixel-create">
    <div class="row">
        <?php $form = ActiveForm::begin([
            'id' => 'pixel-form',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                'inputOptions' => ['class' => 'col-lg-3 form-control'],
                'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
            ],
        ]); ?>

        <?= $form->field($model, 'pixel_id')->textInput(['autofocus' => true])->label('Pixel ID') ?>

        <?= $form->field($model, 'pixel_api')->textInput()->label('Pixel API') ?>

        <div class="form-group">
            <div>
                <?= Html::submitButton('Добавить пиксель', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
