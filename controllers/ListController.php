<?php

namespace app\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use app\models\CartridgeList;
use app\controllers\BehaviorsController;

class ListController extends BehaviorsController
{
    public function actionIndex()
    {
        $query = CartridgeList::find();

        $pagination = new Pagination([
            'defaultPageSize' => 15,
            'totalCount' => $query->count(),
        ]);

        $cartridges = $query->orderBy('id')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'cartridges' => $cartridges,
            'pagination' => $pagination,
        ]);
    }
}