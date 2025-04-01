<?php
use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\AddReviewFormWidget;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<div class="wrap">
    <div id="header" class="header"><?= $this->render('//layouts/header') ?></div>
    <div id="menu" class="menu">
        <div class="menu--item pointer <?php if($this->title === 'Главная'): ?>active<?php endif; ?>" onclick="openPage('<?= Url::to(['/']) ?>')">Главная</div>
        <div class="menu--item pointer <?php if($this->title === 'Отзывы'): ?>active<?php endif; ?>" onclick="openPage('<?= Url::to(['get-reviews/get']) ?>')">Отзывы</div>
        <?php if (!Yii::$app->user->isGuest): ?>
            <div class="menu--item pointer" onclick="openPage('<?= Url::to(['user/profile']) ?>')">Мой профиль</div>
        <?php endif; ?>
    </div>
    <div id="add-comment" class="add-comment no-display"><?= AddReviewFormWidget::widget() ?></div>
    <div class="page-content">
        <?= $content ?>
    <div>
    <div id="footer" class="footer"><?= $this->render('//layouts/footer') ?></div>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>