<?php

namespace app\controllers;

use app\models\Reviews;
use yii\web\Controller;
use yii\web\Request;
use yii\helpers\Url;
use Yii;
use yii\helpers\VarDumper;

class AddReviewController extends Controller
{
    public function actionAdd(Request $request)
    {
        $model = new Reviews();
        
        if ($model->load($request->post()) && $model->validate()) {
            if (!Yii::$app->user->isGuest) {
                $model->user_id = Yii::$app->user->id;
            } else {
                $model->user_id = 1;
                $model->is_recommended = 'none';
            }
            if ($model->save()) {
                return $this->redirect(Url::toRoute(['get-reviews/get']));
            } else {
                Yii::$app->session->setFlash('error', $model->getErrors());
                return $this->redirect(Yii::$app->request->referrer);
            }
        } else {
            return $this->render('site/index');
        }
    }
}
?>