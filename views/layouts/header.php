<?php

use yii\helpers\Html;
use yii\helpers\Url;
use Yii;
use app\assets\AppAsset;
AppAsset::register($this);
?>

<div class="header--info">
    <div class="logo">
        logo text
    </div>
    <div class="right-block">
        <div class="but" onclick="openPopup()">
            <img class="add--icon" src="<?= Yii::$app->assetManager->getBundle('app\assets\AppAsset')->baseUrl ?>/image/Plus.png">
            <span class="add--text">Добавить отзыв</span>
        </div>
        <?php if (Yii::$app->user->isGuest): ?>
            <div class="button" onclick="openPage('<?= Url::to(['auth/authentication']) ?>')" not-authorized>
                Войти
            </div>
        <?php endif; ?>
        <?php if (!Yii::$app->user->isGuest): ?>
            <div class="person pointer" onclick="openPersonPopup()">
                <?php if (Yii::$app->user->identity->image): ?>
                    <img src="<?= Yii::$app->user->identity->image ?>" alt="User Avatar" width="50" height="50" style="border-radius: 50%;">
                <?php else: ?>
                    <img src="https://avatars.mds.yandex.net/i?id=e9213621c435c234cc2415b97ae55232_l-4571652-images-thumbs&n=13" alt="Default user Avatar" width="50" height="50" style="border-radius: 50%;">
                <?php endif; ?>
                <span class="person--nickname"><?= Html::encode(Yii::$app->user->identity->login) ?></span>
            </div>

            <div class="person-popup no-display" id="person-popup">
                <img class="arrow" src="<?= Yii::$app->assetManager->getBundle('app\assets\AppAsset')->baseUrl ?>/image/arrow-wrapper.svg">
                <div class="person-popup--items">
                    <div class="item pointer" onclick="openPage('<?= Url::to(['user/profile']) ?>')">
                        <img src="">
                        Мой профиль
                    </div>
                    <div class="item pointer" onclick="openPage('<?= Url::to(['site/privacy-policy']) ?>')">
                        <img src="">
                        Политика конфиденциальности
                    </div>
                    <div class="hr"></div>
                    <div class="item pointer">
                        <img src="">
                        <a onclick="actionLogout()">">Выйти</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
