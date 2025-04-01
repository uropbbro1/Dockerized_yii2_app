<?php

namespace app\controllers;

use app\models\Reviews;
use app\models\NewUsers;
use yii\data\Pagination;
use yii\db\Query;
use yii\web\Controller;
use Yii;

class GetReviewsController extends Controller
{
    public $layout = 'main';
    public function actionGet()
    {
        $request = Yii::$app->request;

        $isSearched = $request->get('is-searched');
        $isSorted = $request->get('is-sorted');

        $query = (new Query())
            ->select(['reviews.*', 'new_users.login', 'new_users.image'])
            ->from('reviews')
            ->leftJoin('new_users', 'reviews.user_id = new_users.id');

        if ($isSearched) {
            $query->andWhere(['like', 'text', $isSearched]);

            if ($isSorted === '1') {
                $query->orderBy(['reviews.created_at' => SORT_ASC]);
            } else {
                $query->orderBy(['reviews.created_at' => SORT_DESC]);
            }
        }
        
        $countQuery = clone $query;
        $reviewsCount = $countQuery->count();

        $pagination = new Pagination([
            'totalCount' => $reviewsCount,
            'pageSize' => 3,
        ]);

        $reviews = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        
        return $this->render('comments', [
            'reviews' => $reviews,
            'reviewsCount' => $reviewsCount,
            'sorted' => ($isSearched && $isSorted === '1') ? -1 : 1,
            'completeSearch' => $isSearched,
            'pagination' => $pagination,
        ]);
    }

    public function actionSearch()
    {
       //TODO: implement search
    }
}