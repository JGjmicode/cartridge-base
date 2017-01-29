<?php
namespace app\controllers;
use yii\helpers\Url;
use app\models\Cartridges;
use yii\web\Controller;
use app\models\CartridgesSearch;
use yii;
use app\models\CartridgesForm;
use app\controllers\BehaviorsController;

class CartridgesController extends BehaviorsController{
    
    public function actionIndex(){
            $searchModel = new CartridgesSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->get());
            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]);
    }
    
    public function actionAdd(){
        $cartridge = new Cartridges;
        $model = new CartridgesForm;
        $invNumber =  Cartridges::getMaxInvNumber();
        $model->inv_number = $invNumber;
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $cartridge->saveCartridge($model);
            return $this->redirect(Url::to(['cartridges/index']));
        }else{
            return $this->render('edit-cartridge', ['model' => $model, 'invNumber' => $invNumber]);
        }
    }
    
    public function actionUpdate(){
        $model = new CartridgesForm;
        $invNumber =  Cartridges::getMaxInvNumber();
        $cartridge = Cartridges::findOne(Yii::$app->request->get('id'));
        $model->model = $cartridge->model;
        $model->serial = $cartridge->serial;
        $model->printer_id = $cartridge->printer_id;
        $model->inv_number = $cartridge->inv_number;
        $model->inv_service = $cartridge->inv_service;
        $model->note = $cartridge->note;
        $model->supplier_id = $cartridge->supplier_id;
        $model->resource = $cartridge->resource;
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $cartridge->saveCartridge($model);
            return $this->redirect(Url::to(['cartridges/index']));
        }else{
            return $this->render('edit-cartridge', ['model' => $model, 'invNumber' => $invNumber]);
        }
    }
    
    public function actionDelete(){
        Cartridges::deleteCartridge(Yii::$app->request->get('id'));
        return $this->redirect(Url::to(['cartridges/index']));
    }
}

