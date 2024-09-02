<?php

/* @var $this yii\web\View */
/* @var $model app\models\FilterForm */

/* @var $dataProvider yii\data\ActiveDataProvider */

use app\models\ChannelForm;
use app\models\Pixel;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

$channels = ChannelForm::find()->select(['id', 'channel_name'])->asArray()->all();
$channelList = ArrayHelper::map($channels, 'id', 'channel_name');

$pixels = Pixel::find()->select(['id', 'pixel_title'])->asArray()->all();
$pixelList = ArrayHelper::map($pixels, 'id', 'pixel_title');

$this->title = 'Медиа статистика';
?>
<div class="users-index mt-5">
    <?php if (Yii::$app->user->identity->role === 'Admin' || Yii::$app->user->identity->role === 'TeamLeadMediabuyer'): ?>
        <h1>Административная статистика</h1>
    <?php else: ?>
        <h1>Ваша статистика</h1>
    <?php endif; ?>

    <div class="filter-form">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'groupBy')->dropDownList([
            'pixel_id' => 'ID пикселям',
            'channel_name' => 'По каналам',
            'campaign_id' => 'ID компаниям',
            'campaign_name' => 'Названию компаний',
            'ad_id' => 'ID объявлений',
            'adset_id' => 'ID групп объявлений',
            'adset_name' => 'Название групп объявлений',
            'site_source_name' => 'По источникам трафика',
            'placement' => 'По местам размещения',

        ], ['prompt' => 'Select Grouping']) ?>

        <?= $form->field($model, 'startDate')->input('date') ?>
        <?= $form->field($model, 'endDate')->input('date') ?>

        <?= $form->field($model, 'channel_name')->dropDownList($channelList, ['prompt' => 'Select Channel']) ?>

        <?= $form->field($model, 'pixel_id')->dropDownList($pixelList, ['prompt' => 'Select Pixel']) ?>

        <div class="form-group">
            <?= Html::submitButton('Filter', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Reset', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'campaign_id',
            'ad_id',
            'created_at',
            [
                'attribute' => 'count',
                'label' => 'Count',
                'value' => function ($data) {
                    return $data['count'];
                },
            ],
        ],
    ]); ?>
</div>