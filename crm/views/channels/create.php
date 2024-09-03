<?php

use app\models\Pixel;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ChannelForm */
/* @var $bot app\models\TelegramBot */
/* @var $form yii\widgets\ActiveForm */

$pixels = Pixel::find()->all();
$pixelOptions = ArrayHelper::map($pixels, 'pixel_id', function ($element) {
    return $element['pixel_id'] . ' - ' . $element['owner'];
});

?>
    <div class="channel-create">

        <div class="channel-form">

            <?php $form = ActiveForm::begin([
                'id' => 'create-channel-form',
                'options' => ['data-pjax' => false],
                'enableClientValidation' => true,
            ]); ?>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'channel_name')->textInput(['maxlength' => true, 'placeholder' => 'Название для системы'])->label('Название канала') ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($model, 'channel_id')->textInput(['placeholder' => '-1005456498456'])->label('ID канала') ?>
                </div>
            </div>

            <?= $form->field($model, 'channel_bot')->textInput(['maxlength' => true, 'placeholder' => '7378948848:AAGsMrHRTi7WCu6-qMPo0MWFZl3A0W1Ii7Q'])->label('Токен для бота') ?>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'telegram_account')->textInput(['maxlength' => true, 'placeholder' => '7378948848'])->label('ID Telegram аккаунта') ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($bot, 'bot_name')->textInput(['maxlength' => true, 'placeholder' => 'Название для бота'])->label('Название для бота') ?>
                </div>
            </div>

            <?= $form->field($model, 'selectedPixels')->widget(Select2::class, [
                'data' => $pixelOptions,
                'options' => ['placeholder' => 'Выберите facebook pixel', 'multiple' => true],
                'pluginOptions' => [
                    'tags' => true,
                    'tokenSeparators' => [',', ' '],
                ],
            ])->label('Pixel'); ?>

            <div class="form-group mt-5">
                <?= Html::submitButton('Добавить канал', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>

    </div>