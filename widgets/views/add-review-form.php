<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="comment-form">
    <div class="popup--title">
        Новый отзыв
        <div class="close pointer" onclick="closePopup()">
            <img src="./image/close.svg">
        </div>
    </div>
    <?php $form = ActiveForm::begin([
        'action' => ['add-review/add'],
        'method' => 'post',
    ]); ?>
        <div class="comment--info">
            <div class="field">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            </div>
            
            <div class="field">
                <?= $form->field($model, 'text')->textarea(['rows' => 15]) ?>
            </div>
            <?php if(Yii::$app->user->id): ?>
                <div class="field--radio">
                    <?= $form->field($model, 'is_recommended')->radioList([
                        'yes' => 'Да',
                        'no' => 'Нет',
                    ]) ?>
                </div>
            <?php else: ?>
                <div class="field">
                    Для того, чтобы оставить рекомендацию к отзыву, <a href="./authentication">войдите или зарегистрируйтесь</a>
                </div>
            <?php endif; ?>
        </div>
    <div class="comment--footer buttons">
        <?= Html::submitButton('Отправить отзыв', ['class' => 'button primary']) ?>
        <div class="button" onclick="closePopup()">Назад</div>
    </div>
    <?php ActiveForm::end(); ?>
</div>