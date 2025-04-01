<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\RegisterForm;

class AuthController extends Controller
{
    public function actionAuthentication()
    {
        $loginModel = new LoginForm();
        $registerModel = new RegisterForm();

        return $this->render('authentication', [
            'loginModel' => $loginModel,
            'registerModel' => $registerModel,
        ]);
    }

    public function actionLogin()
    {
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->login()) {
                return $this->goHome();
            } else {
                $model->addError('password', 'Неверный email или пароль.');
            }
        }

        return $this->render('authentication', [
            'loginModel' => $model,
            'registerModel' => new RegisterForm(),
        ]);
    }

    public function actionRegister()
    {
        $model = new RegisterForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->register()) {
                return $this->redirect(['authentication']);
            }
        }

        return $this->render('authentication', [
            'loginModel' => new LoginForm(),
            'registerModel' => $model,
        ]);
    }
}