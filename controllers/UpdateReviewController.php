<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\Reviews;
use yii\web\Request;

class UpdateReviewController extends Controller
{
    public function actionUpdateReview()
    {
        $request = Yii::$app->request;

        // Получаем id отзыва из запроса
        $reviewId = $request->post('id');
        $review = Reviews::findOne($reviewId);

        if (!$review) {
            throw new NotFoundHttpException('Отзыв не найден');
        }

        // Правила валидации
        $rules = [
            ['title', 'required', 'message' => 'Заголовок должен быть заполненным'],
            ['title', 'string', 'max' => 255, 'message' => 'Заголовок не может быть длинее 255 символов'],
            ['text', 'required', 'message' => 'Текст отзыва должен быть заполненным'],
            ['text', 'string', 'max' => 5000, 'message' => 'Текст отзыва не может быть длинее 5000 символов'],
            ['is_recommended', 'required', 'message' => 'Выберите рекомендуете вы товар или нет.'],
        ];

        // Валидация данных
        $review->load($request->post(), ''); // Загружаем данные из запроса в модель

        if (!$review->validate()) {
            // Если валидация не прошла, возвращаем с ошибками
            Yii::$app->session->setFlash('error', 'Пожалуйста, исправьте ошибки.');
            return $this->redirect(['review/update', 'id' => $review->id]);
        }

        // Обновляем отзыв в базе данных
        $review->title = $request->post('title');
        $review->text = $request->post('text');
        $review->is_recommended = $request->post('is_recommended');
        
        if ($review->save()) {
            Yii::$app->session->setFlash('success', 'Отзыв успешно обновлен');
        } else {
            Yii::$app->session->setFlash('error', 'Ошибка при обновлении отзыва');
        }

        return $this->redirect(['get-reviews/get']);
    }
}