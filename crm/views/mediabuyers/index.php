<?php

/* @var $this yii\web\View */

$this->title = 'Медиа статистика';
?>
<div class="users-index mt-5">
    <?php
    if (Yii::$app->user->identity->role === 'Admin' || Yii::$app->user->identity->role === 'TeamLeadMediabuyer') {
        ?>
      <h1>Административная статистика</h1>
        <?php
    } else {
        ?>
      <h1>Ваша статистика</h1>
        <?php
    }
    ?>

</div>