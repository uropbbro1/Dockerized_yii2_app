<?php

namespace app\controllers;

use app\models\ChangePasswordForm;
use Yii;
use yii\web\Controller;
use app\models\NewUsers;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

class UpdateDataController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['update-data'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionUpdateData()
    {
        $user = NewUsers::findOne(Yii::$app->user->id);
        if (!$user) {
            throw new NotFoundHttpException('Пользователь не найден.');
        }

        if ($user->load(Yii::$app->request->post())) {
            $user->scenario = 'updateProfile';
            
            if (!$user->validatePassword(Yii::$app->request->post('NewUsers')['password'])) {
                $user->addError('password', 'Неверный пароль');
            }

            if (NewUsers::find()->where(['email' => $user->email])->andWhere(['!=', 'id', $user->id])->exists()) {
                $user->addError('email', 'Такой email уже зарегистрирован');
            }
            
            if (NewUsers::find()->where(['login' => $user->login])->andWhere(['!=', 'id', $user->id])->exists()) {
                $user->addError('login', 'Этот никнейм уже занят');
            }

            if (!$user->hasErrors() && $user->save(false)) {
                return $this->redirect(['user/profile']);
            }
        }

        return $this->render('update-data', [
            'model' => $user,
        ]);
    }

    /*public function actionChangePassword()
    {
        $model = new ChangePasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->changePassword()) {
                Yii::$app->session->setFlash('change-password-success', 'Пароль успешно изменен');
                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('change-password-error', 'Не удалось изменить пароль.');
            }
        }

        // Отправляем модель в представление для отображения формы
        return $this->render('change-password', [
            'model' => new ChangePasswordForm(),
        ]);
    }*/
}