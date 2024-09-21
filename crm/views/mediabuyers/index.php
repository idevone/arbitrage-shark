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
use app\models\FilterForm;

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

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'channel_name')->dropDownList($channelList, ['prompt' => 'Select Channel']) ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($model, 'pixel_id')->dropDownList($pixelList, ['prompt' => 'Select Pixel']) ?>
            </div>
        </div>


        <?= $form->field($model, 'endDate')->input('date') ?>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'channel_name')->dropDownList($channelList, ['prompt' => 'Select Channel']) ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($model, 'pixel_id')->dropDownList($pixelList, ['prompt' => 'Select Pixel']) ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Filter', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Reset', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <?php if (!empty($model->groupBy)) {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'label' => 'Группировка',
                    'value' => function ($model) {
                        if (is_object($model) && property_exists($model, 'groupBy')) {
                            return $model->{$model->groupBy};
                        } elseif (is_array($model) && array_key_exists('groupBy', $model)) {
                            return $model[$model['groupBy']];
                        } else {
                            return null;
                        }
                    },
                ],
                [
                    'label' => 'Кликов',
                    'value' => function ($model) {

                    },
                ],
                [
                    'attribute' => 'campaign_name',
                    'label' => 'Название компании',
                ],
                [
                    'attribute' => 'ad_id',
                    'label' => 'ID объявления',
                ],
                [
                    'attribute' => 'adset_id',
                    'label' => 'ID группы объявлений',
                ],
                [
                    'attribute' => 'adset_name',
                    'label' => 'Название группы объявлений',
                ],
                [
                    'attribute' => 'site_source_name',
                    'label' => 'Источник трафика',
                ],
                [
                    'attribute' => 'placement',
                    'label' => 'Место размещения',
                ],
                [
                    'attribute' => 'count',
                    'label' => 'Количество',
                ],
            ],
        ]);
        echo $model->groupBy . '<br>';
        echo $model->groupBy[0] . '<br>';
        echo $model->groupBy[1] . '<br>';
        echo $model->groupBy[2] . '<br>';
        echo $model->groupBy[3] . '<br>';
    } else {
        echo 'Пожалуйста, выберите группировку для отображения данных';
    } ?>
</div>