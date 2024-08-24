<?php

use app\models\Pixel;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Pixel */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="pixel-update">

    <div class="pixel-form">

        <?php $form = ActiveForm::begin([
            'id' => 'update-pixel-form',
            'options' => ['data-pjax' => false],
            'enableClientValidation' => true,
        ]); ?>

        <?= $form->field($model, 'pixel_id')->textInput(['maxlength' => true])->label('Pixel ID') ?>
        <?= $form->field($model, 'pixel_api')->textInput(['maxlength' => true])->label('Pixel API') ?>
        <?= $form->field($model, 'pixel_title')->textInput(['maxlength' => true])->label('Название Pixel\'a') ?>

        <div class="form-group mt-5">
            <?= Html::submitButton('Обновить данные', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
