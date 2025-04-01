<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Аутентификация</title>
</head>
<body>
    <div class="content">
        <div class="popup">
            <div class="popup--tabs" id="popup-tabs">
                <div id="auth" class="tab pointer active">Вход</div>
                <div id="registration" class="tab pointer">Регистрация</div>
            </div>
            <div id="auth-data" class="popup--fields">
                <?php $form = ActiveForm::begin(['action' => ['auth/login'], 'method' => 'post']); ?>

                <?= $form->field($loginModel, 'email')->textInput(['placeholder' => 'Введите ваш email']) ?>
                <?= $form->field($loginModel, 'password')->passwordInput(['placeholder' => 'Введите пароль']) ?>

                <div class="field text-right">
                    <?= Html::a('Забыли пароль?', ['site/password-recovery'], ['class' => 'no-decoration']) ?>
                </div>

                <div class="field">
                    <?= Html::submitButton('Войти', ['class' => 'button primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>

            <div id="registration-data" class="popup--fields no-display">
                <?php $form = ActiveForm::begin(['action' => ['auth/register'], 'method' => 'post']); ?>

                <?= $form->field($registerModel, 'login')->textInput(['placeholder' => 'Логин']) ?>
                <?= $form->field($registerModel, 'email')->textInput(['placeholder' => 'Email']) ?>
                <?= $form->field($registerModel, 'password')->passwordInput(['id' => 'password'])
                    ->label('Пароль <span class="password-toggle" onclick="togglePassword(\'password\')">&#128065;</span>') ?>

                <?= $form->field($registerModel, 'password_repeat')->passwordInput(['id' => 'password_repeat'])
                    ->label('Повторите пароль <span class="password-toggle" onclick="togglePassword(\'password_repeat\')">&#128065;</span>') ?>
                <?= $form->field($registerModel, 'agreement')->checkbox()->label('Я даю согласие на <a href="./privacy-policy">обработку данных</a>') ?>

                <div class="field">
                    <?= Html::submitButton('Зарегистрироваться', ['class' => 'button primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</body>
</html>
<?php if (Yii::$app->session->hasFlash('error')): ?>
<script>
    openAddReview();
</script>
<?php endif; ?>