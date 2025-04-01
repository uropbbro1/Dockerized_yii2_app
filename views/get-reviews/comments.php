<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\models\Reviews; // Подключаем модель Reviews
use app\models\NewUsers; // Подключаем модель NewUsers
use yii\widgets\ActiveForm; // Для создания форм
use app\assets\AppAsset;
AppAsset::register($this);

$this->title = 'Отзывы';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="content with-pagination">
    <h2>Отзывы</h2>
    <div class="filters">
        <div class="search">
            <?php $form = ActiveForm::begin([
                #'action' => ['get-reviews/search'],
                'method' => 'post',
                'options' => ['style' => 'display:flex;flex-direction:column;'],
            ]); ?>
                <div style="display:flex;flex-direction:row;">
                    <img src="" />
                    <input type="text" name="search_term" placeholder="Найти...">
                </div>
                <button class="search-button" type="submit">Поиск</button>
                <?php ActiveForm::end(); ?>
        </div>
        <br><br>
        <div class="field">
            <div class="sort">
                <?php
                $sortUrl = Url::to(['get-reviews/get']);
                if (isset($completeSearch)) {
                    $sortUrl = Url::to(['get-reviews/get', 'is-searched' => $completeSearch, 'is-sorted' => $sorted]);
                }
                ?>
                <span onclick="updateSort('<?= $sortUrl ?>')" id="sort" class="up">по дате <img src=""></span>
            </div>
            <div class="all-count">
                Найден(о) <?= Html::encode($reviewsCount) ?> отзыв(а/ов)
            </div>
        </div>
    </div>

    <!--  циклом выдавать сюда отзывы  -->
    <?php if (!(count($reviews) > 0)): ?>
        <p>Отзывов еще нет</p>
    <?php else: ?>
        <?php foreach ($reviews as $review): ?>
            <div class="comment">
                <div class="person">
                    <?php if ($review["image"]): ?>
                        <img src="<?= $review["image"] ?>" alt="User Avatar" width="100" height="100" style="border-radius: 50%;">
                    <?php else: ?>
                        <img src="https://avatars.mds.yandex.net/i?id=e9213621c435c234cc2415b97ae55232_l-4571652-images-thumbs&n=13" alt="Default user Avatar" width="100" height="100" style="border-radius: 50%;">
                    <?php endif; ?>
                    <span class="person--nickname"><?php if (!$review["login"]): ?> Гость <?php else: ?> <?= Html::encode($review["login"]) ?> <?php endif; ?></span>
                </div>
    
                <div class="date">
                    Отзыв от: <?= Yii::$app->formatter->asDate($review["created_at"], 'php:Y-m-d') ?>
                </div>
    
                <div class="date">
                    Отзыв изменен: <?= Yii::$app->formatter->asDate($review["updated_at"], 'php:Y-m-d') ?>
                </div>
    
                <div class="comment--title">
                    <?= Html::encode($review["title"]) ?>
                </div>
    
                <div class="comment--data">
                    <p class="review-text" data-fulltext="<?= Html::encode($review["text"]) ?>">
                        <?php if (mb_strlen($review["text"]) > 350 || substr_count($review["text"], "\n") > 3): ?>
                            <?= Html::encode(mb_substr($review["text"], 0, 350)) ?>...
                        <?php else: ?>
                            <?= Html::encode($review["text"]) ?>
                        <?php endif; ?>
                    </p>
                </div>
                <?php if (mb_strlen($review["text"]) > 350 || substr_count($review["text"], "\n") > 3): ?>
                    <div class="buttons">
                        <div class="button" onclick="showAll(<?= Html::encode($review['id']) ?>)">Читать весь отзыв</div>
                    </div>
                <?php endif; ?>

                <?php if (Yii::$app->user->id == $review["user_id"]): ?>
                    <button class="change-button" onclick="openReviewUpdate(<?= Html::encode($review['id']) ?>)">Редактировать</button>
                <?php endif; ?>
    
                <!-- высплывающее окно для каждого отзыва -->
                <div id="popup-comment<?= Html::encode($review["id"]) ?>" class="comment-focus popup-comment no-display">
                    <div class="comment-form">
                        <div class="popup--title">
                            Отзыв
                            <div class="close pointer" onclick="closeReviewPopup(<?= Html::encode($review['id']) ?>)">
                                <img src="">
                            </div>
                        </div>
                        <div class="comment--info">
                            <div class="person">
                                <?php if ($review["image"]): ?>
                                    <img src="<?= $review["image"] ?>" alt="User Avatar" width="100" height="100" style="border-radius: 50%;">
                                <?php else: ?>
                                    <img src="https://avatars.mds.yandex.net/i?id=e9213621c435c234cc2415b97ae55232_l-4571652-images-thumbs&n=13" alt="Guest Avatar" width="100" height="100" style="border-radius: 50%;">
                                <?php endif; ?>
                                <span class="person--nickname"><?php if (!$review["login"]): ?> Гость <?php else: ?> <?= Html::encode($review["login"]) ?> <?php endif; ?></span>
                            </div>
                            <div class="comment--title">
                                <?= Html::encode($review["title"]) ?>
                            </div>
                            <div class="comment--data">
                                <?= Html::encode($review["text"]) ?>
                            </div>
                            <?php if ($review['is_recommended'] === 'yes'): ?>
                                <div class="recommend">
                                    <img src="">
                                    <div>
                                        <div class="nickname"><?= Html::encode($review["login"]) ?></div>
                                        <div class="status">рекомендует</div>
                                    </div>
                                </div>
                            <?php elseif ($review['is_recommended'] === 'no'): ?>
                                <div class="recommend no-recommend">
                                    <img src="">
                                    <div>
                                        <div class="nickname"><?= Html::encode($review["login"]) ?></div>
                                        <div class="status">нерекомендует</div>
                                    </div>
                                </div>
                            <?php else: ?>
                            <?php endif; ?>
                        </div>
                        <div class="comment--footer buttons">
                            <div class="button" onclick="closeReviewPopup(<?= Html::encode($review['id']) ?>)">Назад</div>
                        </div>
                    </div>
                </div>
    
                
                <!-- высплывающее окно для реадактирования каждого отзыва -->
                <div id="review-update<?= Html::encode($review['id']) ?>" class="comment-focus review-update no-display">
                    <div class="comment-form">
                        <?php $form = ActiveForm::begin([
                            'action' => ['update-review/update-review'],
                            'method' => 'post',
                        ]); ?>
                            <?= Html::hiddenInput('id', $review['id']) ?>
                            <div class="popup--title">
                                Редактировать отзыв
                                <div class="close pointer" onclick="closeReviewPopup(<?= Html::encode($review['id']) ?>)">
                                    <img src="">
                                </div>
                            </div>
                            <div class="comment--info">
                                <div class="field">
                                    <label class="field--label">Новый заголовок отзыва одной фразой</label>
                                    <div class="field--data">
                                        <?= Html::textInput('title', Html::encode($review['title']), ['required' => true]) ?>
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="field--label">Ваш новый отзыв</label>
                                    <?= Html::textarea('text', Html::encode($review['text']), ['class' => 'field--data', 'rows' => 20, 'required' => true]) ?>
                                </div>
                                <div class="field--radio">
                                    <label class="field--label">Вы бы порекомендовали это?</label>
                                    <div class="field--data">
                                        <?= Html::radio('is_recommended', $review['is_recommended'] === 'yes', ['value' => 'yes', 'id' => 'is_recommended_yes']) ?>
                                        <label for="is_recommended_yes">Да</label>
                                    </div>
                                    <div class="field--data">
                                        <?= Html::radio('is_recommended', $review['is_recommended'] === 'no', ['value' => 'no', 'id' => 'is_recommended_no']) ?>
                                        <label for="is_recommended_no">Нет</label>
                                    </div>
                                </div>
                            </div>
                            <div class="comment--footer buttons">
                                <?= Html::submitButton('Редактировать отзыв', ['class' => 'button primary']) ?>
                                <div class="button" onclick="closeReviewPopup(<?= Html::encode($review['id']) ?>)">Назад</div>
                            </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <div class="pagination">
    <?= LinkPager::widget([
        'pagination' => $pagination,
    ]) ?>
</div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->beginPage() ?>
<?php $this->head() ?>
<?php $this->endPage() ?>

<?php
// Скрипты для обработки сессий
$js = <<<JS
    // Скрипт для открытия popup редактирования
    if (sessionStorage.getItem('err')) {
        openReviewUpdate(sessionStorage.getItem('err'));
        sessionStorage.removeItem('err');
    }

    // Скрипт для обновления изображения сортировки
    if (sessionStorage.getItem('sorted') > 0) {
        setTimeout(updateSortImage(), 100);
        sessionStorage.removeItem('sorted');
    }

    // Скрипт для открытия popup добавления отзыва
    if (sessionStorage.getItem('error')) {
        openAddReview();
        sessionStorage.removeItem('error');
    }
JS;

$this->registerJs($js);
?>
<script>
    function showAll(id) {
        $(`#popup-comment${id}`).removeClass('no-display');
    }
</script>
