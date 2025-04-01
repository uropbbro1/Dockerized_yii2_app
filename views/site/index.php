<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AppAsset;

$this->title = 'Главная';
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="content">
    <h2>Главная</h2>
    <div class="paragraph">
        <p>ГОЛ!</p>
        <p>Данная страница является домашней страницей, и служит для перехода в остальные разделы.</p>
        <p>Нажмите “Отзывы” для перехода к странице с отзывами.</p>
        <p>Нажмите “Мой профиль” для просмотра своего профиля. (Отображается только в авторизованном варианте страницы)</p>
        <p>Авторизуйтесь для просмотра своего профиля. (Отображается только в неавторизованном варианте страницы)</p>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>