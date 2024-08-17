<?php
/* @var $this yii\web\View */
/* @var $id string */
?>
<h1>Channel: <?= \yii\helpers\Html::encode($id) ?></h1>

<?php if ($id == '1'): ?>
    <p>This is content for Channel 1.</p>
<?php elseif ($id == '2'): ?>
    <p>This is content for Channel 2.</p>
<?php else: ?>
    <p>This is dynamic content for Channel <?= \yii\helpers\Html::encode($id) ?>.</p>
<?php endif; ?>
