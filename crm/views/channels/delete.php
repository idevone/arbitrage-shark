<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ChannelsForm */

?>
<h1>Delete Record</h1>

<p>Are you sure you want to delete this record?</p>

<?= Html::a('Delete', ['delete', 'id' => $model->id], [
    'class' => 'btn btn-danger',
    'data' => [
        'method' => 'post',
        'confirm' => 'Are you sure you want to delete this item?',
    ],
]) ?>

<?= Html::a('Cancel', ['index'], ['class' => 'btn btn-default']) ?>
