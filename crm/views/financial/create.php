<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-create">

    <div class="user-form">

        <?php $form = ActiveForm::begin([
            'id' => 'create-user-form',
            'options' => ['data-pjax' => false],
            'enableClientValidation' => true,
        ]); ?>

        <?= $form->field($model, 'amount')->textInput(['autofocus' => true])->label('Сумма платежа') ?>

        <?= $form->field($model, 'purpose')->textInput()->label('Назначение платежа') ?>

        <div class="form-group">
            <?= Html::submitButton('Добавить платеж', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
