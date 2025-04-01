<?php

use app\models\ChangePasswordForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

 $model->password = '';
?>
<div class="content">
    <h2>Мой профиль</h2>
    <div class="profile">
        <div class="my-profile">
            <div class="my-profile-info">
                <div class="photo">
                    <?php if (Yii::$app->user->identity->image): ?>
                        <img src="<?= Yii::$app->user->identity->image ?>" alt="User Avatar" width="100" height="100" style="border-radius: 5px;">
                    <?php else: ?>
                        <img src="https://avatars.mds.yandex.net/i?id=e9213621c435c234cc2415b97ae55232_l-4571652-images-thumbs&n=13" alt="Default user Avatar" width="100" height="100" style="border-radius: 5px;">
                    <?php endif; ?>
                </div>
                <div class="info">
                    <div class="info--nickname"><?= Yii::$app->user->identity->login ?></div>
                    <div>ID: <?= Yii::$app->user->identity->id ?></div>
                    <div class="info--update-photo pointer" onclick="openChangeAvatar()">Заменить фото</div>
                </div>
            </div>
            <?php if(isset($changed)): ?><p style="color:green;">Пароль успешно изменен</p><?php endif;?>
            <div class="my-profile-change-avatar-form">
                <div id="change-avatar-block" class="no-display">
                    <?php $form = ActiveForm::begin([
                        'action' => 'user/change-avatar',
                        'options' => ['enctype' => 'multipart/form-data']]); ?>
                        <?= $form->field($model, 'imageFile')->fileInput()->label('Загрузить новый аватар') ?>
                        <?php if (Yii::$app->session->hasFlash('error')): ?>
                            <div class="alert alert-danger">
                                <?= Yii::$app->session->getFlash('error'); ?>
                            </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>

            <div class="update-data">
                <?php if (Yii::$app->session->hasFlash('change-password-success')): ?>
                    <div class="alert alert-success"><?= Yii::$app->session->getFlash('change-password-success') ?></div>
                <?php endif; ?>
                <?php $form = \yii\widgets\ActiveForm::begin([
                    'action' => ['user/update-data'],
                    'method' => 'post'
                ]); ?>
                    <div class="form-row1" style="display: flex;flex-direction: row;gap: 20px;">
                        <div class="fields">
                            <?= $form->field($model, 'login')->textInput(['value' => Yii::$app->user->identity->login])->label('Логин / Имя пользователя') ?>
                        </div>
                        <div class="fields">
                            <?= $form->field($model, 'email')->textInput(['value' => Yii::$app->user->identity->email])->label('E-mail') ?>
                        </div>
                    </div>
                    <div class="form-row2" style="margin: 14px 0;display: flex;flex-direction: row;">
                        <?= $form->field($model, 'password')->passwordInput(['id' => 'user-password', 'placeholder' => 'Введите пароль чтобы изменить данные аккаунта'])->label('Пароль') ?>
                    </div>
                    <?php if (Yii::$app->session->hasFlash('err')): ?>
                        <div class="alert alert-danger"><?= Yii::$app->session->getFlash('err') ?></div>
                    <?php endif; ?>
                    <div class="form-row3" style="margin: 24px 0;display: flex;flex-direction: row;gap:20px;">
                        <button class="button primary" type="submit">Сохранить</button>
                    </div>
                <?php \yii\widgets\ActiveForm::end(); ?>

                <!-- Форма для смены пароля 
                <div id="change-password-form">
                <?php $form = \yii\widgets\ActiveForm::begin([
                    'action' => ['user/change-password'],
                    'method' => 'post'
                ]); ?>

                <?= 1#$form->field($model, 'oldPassword')->passwordInput(['placeholder' => 'Текущий пароль'])->label('Текущий пароль') ?>
                <?= 1#$form->field($model, 'newPassword')->passwordInput(['placeholder' => 'Новый пароль'])->label('Новый пароль') ?>
                <?= 1#$form->field($model, 'confirmPassword')->passwordInput(['placeholder' => 'Подтвердите новый пароль'])->label('Подтвердите новый пароль') ?>

                <button class="button primary" type="submit">Сменить пароль</button>

                <?php \yii\widgets\ActiveForm::end(); ?>
                </div>-->
            </div>
        </div>
    </div>

    <h2 class="review-content">Мои отзывы (<?= count($reviews) ?>)</h2>
        <?php if (!empty($reviews)): ?>
            <?php foreach ($reviews as $review): ?>
                <div class="comment">
                <div class="person">
                    <?php if (!empty(Yii::$app->user->identity->image)): ?>
                        <img src="<?= Yii::$app->user->identity->image ?>" alt="User Avatar" width="50" height="50" style="border-radius: 50%;">
                    <?php else: ?>
                        <img src="https://avatars.mds.yandex.net/i?id=e9213621c435c234cc2415b97ae55232_l-4571652-images-thumbs&n=13" alt="Default user Avatar" width="50" height="50" style="border-radius: 50%;">
                    <?php endif; ?>
                    <span class="person--nickname"><?= !empty(Yii::$app->user->identity->login) ? Yii::$app->user->identity->login : 'Гость' ?></span>
                </div>

                <div class="date">Отзыв от: <?= explode(' ', $review['created_at'])[0] ?></div>
                <div class="date">Отзыв изменен: <?= explode(' ', $review['updated_at'])[0] ?></div>
                <div class="comment--title"><?= $review['title'] ?></div>
                <div class="comment--data">
                    <p class="review-text" data-fulltext="<?= $review['text'] ?>">
                        <?= mb_strlen($review['text']) > 350 || substr_count($review['text'], "\n") > 2 ? mb_substr($review['text'], 0, 350) . '...' : $review['text'] ?>
                    </p>
                </div>
                <div class="buttons">
                    <div class="button" onclick="showAll(<?= Html::encode($review['id']) ?>)">Читать весь отзыв</div>
                </div>

                <?php if (Yii::$app->user->id == $review["user_id"]): ?>
                    <button class="change-button" onclick="openReviewUpdate(<?= Html::encode($review['id']) ?>)">Редактировать</button>
                <?php endif; ?>

                <!-- высплывающее окно для каждого отзыва -->
                <div id="popup-comment<?= Html::encode($review['id']) ?>" class="comment-focus popup-comment no-display">
                    <div class="comment-form">
                        <div class="popup--title">
                            Отзыв
                            <div class="close pointer" onclick="closeReviewPopup(<?= Html::encode($review['id']) ?>)">
                                <img src="">
                            </div>
                        </div>
                        <div class="comment--info">
                            <div class="person">
                                <?php if (Yii::$app->user->identity->image): ?>
                                    <img src="<?= Yii::$app->user->identity->image ?>" alt="User Avatar" width="100" height="100" style="border-radius: 50%;">
                                <?php else: ?>
                                    <img src="https://avatars.mds.yandex.net/i?id=e9213621c435c234cc2415b97ae55232_l-4571652-images-thumbs&n=13" alt="Guest Avatar" width="100" height="100" style="border-radius: 50%;">
                                <?php endif; ?>
                                <span class="person--nickname"><?php if (!Yii::$app->user->identity->login): ?> Гость <?php else: ?> <?= Html::encode(Yii::$app->user->identity->login) ?> <?php endif; ?></span>
                            </div>
                            <div class="comment--title">
                                <?= Html::encode($review["title"]) ?>
                            </div>
                            <div class="comment--data">
                                <?= Html::encode($review["text"]) ?>
                            </div>
                            <?php if ($review["is_recommended"] === 'yes'): ?>
                                <div class="recommend">
                                    <img src="">
                                    <div>
                                        <div class="nickname"><?= Html::encode(Yii::$app->user->identity->login) ?></div>
                                        <div class="status">рекомендует</div>
                                    </div>
                                </div>
                            <?php elseif ($review["is_recommended"] === 'no'): ?>
                                <div class="recommend no-recommend">
                                    <img src="">
                                    <div>
                                        <div class="nickname"><?= Html::encode(Yii::$app->user->identity->login) ?></div>
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
    <?php else: ?>
        <p class="review-content" style="color:blue;">Вы еще не оставляли отзывы!</p>
    <?php endif; ?>
</div>


<script>
    function showAll(id) {
        $(`#popup-comment${id}`).removeClass('no-display');
    }
</script>