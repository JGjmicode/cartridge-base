<?php
namespace app\controllers;

use app\models\Supplier;
use app\models\SupplierForm;
use app\models\SupplierSearch;
use yii\web\Controller;
use Yii;
use yii\helpers\Url;
use app\controllers\BehaviorsController;

class SupplierController extends BehaviorsController{

    public function actionIndex(){
        $searchModel = new SupplierSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        return $this->render('index',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAdd(){
        $model = new Supplier();
        if($model->load(Yii::$app->request->post()) && $model->save()){
            return $this->redirect(Url::to(['/supplier/index' ]));
        }
        return $this->render('edit', [
            'model' => $model
        ]);
    }

    public function actionUpdate(){
        $model = Supplier::findOne(Yii::$app->request->get('id'));
        if($model->load(Yii::$app->request->post()) && $model->save()){
            return $this->redirect(Url::to(['/supplier/index' ]));
        }
        return $this->render('edit', [
            'model' => $model
        ]);
    }

    public function actionDelete(){
        $supplier = Supplier::findOne(Yii::$app->request->get('id'));
        $supplier->delete();
        return $this->redirect(Url::to(['supplier/index']));
    }

}