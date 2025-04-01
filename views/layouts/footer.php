<?php

use yii\helpers\Html;
use yii\helpers\Url;
use Yii;

?>

<div class="left-block">
    <img src="">
</div>
<div class="center">
    <div class="pointer" onclick="openPage('<?= Url::to(['/']) ?>')">Главная</div>
    <div class="pointer" onclick="openPage('<?= Url::to(['get-reviews/get']) ?>')">Отзывы</div>
    <?php if (!Yii::$app->user->isGuest): ?>
        <div class="pointer" authorized onclick="openPage('<?= Url::to(['user/profile']) ?>')">Мой профиль</div>
    <?php endif; ?>
    <div class="pointer" onclick="openPage('<?= Url::to(['site/privacy-policy']) ?>')">Политика обработки персональных данных</div>
</div>
<div class="right-block">Logo Text © 2010 — 2023</div>