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

        <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Имя нового пользователя') ?>

        <?= $form->field($model, 'password_hash')->passwordInput()->label('Пароль для нового пользователя') ?>

        <?= $form->field($model, 'role')->dropDownList([
            'Admin' => 'Администратор',
            'TeamLeadMediabuyer' => 'Тимлид медиабайеров',
            'TeamLeadProcessor' => 'Тимлид обработчиков',
            'Mediabuyer' => 'Медиабайер',
            'Processor' => 'Обработчик',
            'Financial' => 'Финансист',
        ], ['id' => 'role-dropdown'])->label('Роль пользователя') ?>

        <div class="form-group">
            <?= Html::submitButton('Добавить пользователя', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
