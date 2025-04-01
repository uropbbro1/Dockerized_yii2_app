<?php

namespace app\widgets;

use app\models\Reviews;
use yii\base\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use Yii;
use yii\helpers\Url;

class AddReviewFormWidget extends Widget
{
    public function run()
    {
        $model = new Reviews();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (!Yii::$app->user->isGuest) {
                $model->user_id = Yii::$app->user->id;
            } else {
                $model->user_id = -1;
                $model->is_recommended = 'none';
            }

            if ($model->save()) {
                return Yii::$app->response->redirect(Url::to(['get-reviews/get']));
            } else {
                Yii::$app->session->setFlash('error', $model->getErrors());
                return Yii::$app->response->redirect(Yii::$app->request->referrer);
            }
        } else {
            return $this->render('add-review-form', [
                'model' => $model,
            ]);
        }
    }
}