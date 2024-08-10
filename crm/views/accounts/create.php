<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\TelegramAccount $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Добавление нового аккаунта';
?>

<div class="account-create">
    <div class="telegram-auth-form">
        <?php $form = ActiveForm::begin([
            'id' => 'telegram-auth-form',
            'enableClientValidation' => true,
        ]); ?>

        <div class="row">
            <div class="col-6">
                <?= $form->field($model, 'user_id')->textInput(['maxlength' => true, 'autofocus' => true, 'placeholder'=>'123456789'])->label('ID пользователя') ?>
            </div>
            <div class="col-6">
                <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'placeholder'=>'@nickname'])->label('Никнейм пользователя') ?>
            </div>
        </div>

        <div class="row">
            <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true, 'placeholder'=>'+380 73 015 015 15'])->label('Номер телефона') ?>
        </div>

        <div class="row">
            <div class="col-6">
                <?= $form->field($model, 'first_name')->textInput(['maxlength' => true, 'placeholder'=>'Иван'])->label('Имя пользователя') ?>
            </div>
            <div class="col-6">
                <?= $form->field($model, 'last_name')->textInput(['maxlength' => true, 'placeholder'=>'Иванов'])->label('Фамилия пользователя') ?>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <?= $form->field($model, 'api_id')->textInput(['maxlength' => true, 'placeholder'=>'123456789'])->label('API ID') ?>
            </div>
            <div class="col-6">
                <?= $form->field($model, 'api_hash')->textInput(['maxlength' => true, 'placeholder'=>'82b395343d4e25b88c9107e7ece79366'])->label('API Hash') ?>
            </div>
            <a href="https://my.telegram.org/auth?to=apps">API ID и API Hash можно получить тут, создать приложение</a>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Добавить аккаунт', ['class' => 'btn btn-primary mt-5']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>