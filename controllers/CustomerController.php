<?php
namespace app\controllers;


use app\models\Customer;
use app\models\CustomerForm;
use Yii;
use yii\web\Controller;
use app\models\CustomerSearch;
use yii\helpers\Url;
use app\controllers\BehaviorsController;

class CustomerController extends BehaviorsController{

    public function actionIndex(){
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        return $this->render('index',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAdd(){
        $model = new Customer();
        if($model->load(Yii::$app->request->post()) && $model->save()){
            return $this->redirect(Url::to(['/customer/index' ]));
        }
        return $this->render('edit', [
            'model' => $model
        ]);
    }

    public function actionUpdate(){
        $model = Customer::findOne(Yii::$app->request->get('id'));
        if($model->load(Yii::$app->request->post()) && $model->save()){
            return $this->redirect(Url::to(['/customer/index' ]));
        }
        return $this->render('edit', [
            'model' => $model
        ]);
    }

    public function actionDelete(){
        $model = Customer::findOne(Yii::$app->request->get('id'));
        $model->delete();
        return $this->redirect(Url::to(['/customer/index' ]));
    }

}