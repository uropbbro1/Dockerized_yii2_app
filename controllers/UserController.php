<?php
namespace app\controllers;

use app\models\ChangePasswordForm;
use yii\web\Controller;
use app\models\NewUsers;
use app\models\Reviews;
use Yii;
use yii\data\Pagination;
use yii\db\Query;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\UploadedFile;

class UserController extends Controller
{
    public function actionProfile()
    {
        $query = (new Query())
            ->select(['reviews.*', 'new_users.login', 'new_users.image'])
            ->from('reviews')
            ->leftJoin('new_users', 'reviews.user_id = new_users.id')
            ->where(['reviews.user_id' => Yii::$app->user->id]);            

        $countQuery = clone $query;
        $reviews_count = $countQuery->count();
        $pagination = new Pagination([
            'totalCount' => $reviews_count,
            'pageSize' => 3,
        ]);
        $reviews = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $user = NewUsers::findOne(Yii::$app->user->id);

        return $this->render('profile', [
            'model' => $user,
            'reviews' => $reviews,
            'review_count' => $reviews_count
        ]);
    }

    public function actionChangeAvatar()
    {
        $model = NewUsers::findOne(Yii::$app->user->id);

        if (!$model) {
            throw new NotFoundHttpException('Пользователь не найден');
        }

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->imageFile && $model->validate()) {
                if ($model->image) {
                    @unlink(Yii::getAlias('@webroot') . '/uploads/avatars/' . $model->image);
                }

                $fileName = Yii::$app->security->generateRandomString() . '.' . $model->imageFile->extension;
                $filePath = Yii::getAlias('@webroot') . '/uploads/avatars/' . $fileName;

                if ($model->imageFile->saveAs($filePath)) {
                    $newImagePath = '/uploads/avatars/' . $fileName;
                    Yii::$app->db->createCommand()
                        ->update('new_users', ['image' => $newImagePath], ['id' => Yii::$app->user->id])
                        ->execute();
                    Yii::$app->session->setFlash('success', 'Аватар успешно изменён');
                } else {
                    Yii::$app->session->setFlash('error', 'Ошибка при загрузке файла');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Неверный формат файла или размер изображения');
            }
        }

        return $this->redirect(['user/profile']);
    }

    public function actionUpdateData()
    {
        $user = NewUsers::findOne(Yii::$app->user->id);
        if (!$user) {
            throw new NotFoundHttpException('Пользователь не найден');
        }

        $request = Yii::$app->request->post();
        $password = $request['NewUsers']['password'] ?? null;
        $newLogin = $request['NewUsers']['login'] ?? null;
        $newEmail = $request['NewUsers']['email'] ?? null;

        if (!$user->validatePassword($password)) {
            Yii::$app->session->setFlash('err', 'Неверный пароль');
            return $this->redirect(['user/profile']);
        }

        if ($newLogin === $user->login && $newEmail === $user->email) {
            Yii::$app->session->setFlash('err', 'Измените хотя бы одно поле');
            return $this->redirect(['user/profile']);
        }

        if ($newEmail !== $user->email && NewUsers::find()->where(['email' => $newEmail])->exists()) {
            Yii::$app->session->setFlash('err', 'Этот email уже занят');
            return $this->redirect(['user/profile']);
        }

        if ($newLogin !== $user->login && NewUsers::find()->where(['login' => $newLogin])->exists()) {
            Yii::$app->session->setFlash('err', 'Этот логин уже занят');
            return $this->redirect(['user/profile']);
        }

        $query = Yii::$app->db->createCommand()
        ->update('new_users', [
            'login' => $newLogin,
            'email' => $newEmail,
        ], 'id = :id', [':id' => Yii::$app->user->id])
        ->execute();
        if ($query) {
            Yii::$app->session->setFlash('success', 'Данные обновлены');
        } else {
            Yii::$app->session->setFlash('err', 'Ошибка обновления');
        }

        return $this->redirect(['user/profile']);
    }

    public function actionCheckPassword()
    {
        $password = Yii::$app->request->post('password');
        $user = Yii::$app->user->identity;

        if (Yii::$app->security->validatePassword($password, $user->password_hash)) {
            return $this->asJson(['success' => true]);
        }
        
        return $this->asJson(['success' => false]);
    }

    public function actionChangePassword()
    {
        /*$model = new ChangePasswordForm();

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
            'model' => $model,
            'changed' => true
        ]);

        return $this->render('profile', [
            'model' => $user,
            'reviews' => $reviews,
            'review_count' => $reviews_count,
            'changed' => true
        ]);*/
    }
}