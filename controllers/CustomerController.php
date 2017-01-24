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
        $model = new CustomerForm();
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $customer = new Customer();
            $customer->saveCustomer($model);
            return $this->redirect(Url::to(['/customer/index' ]));
        }
        return $this->render('edit', [
            'model' => $model
        ]);
    }

    public function actionUpdate(){
        $model = new CustomerForm();
        $customer = Customer::findOne(Yii::$app->request->get('id'));
        $model->name = $customer->name;
        $model->nameRP = $customer->nameRP;
        $model->position = $customer->position;
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $customer->saveCustomer($model);
            return $this->redirect(Url::to(['/customer/index' ]));
        }
        return $this->render('edit', [
            'model' => $model
        ]);
    }

}