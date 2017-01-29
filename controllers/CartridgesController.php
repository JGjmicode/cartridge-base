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
        $model = new Cartridges;
        $invNumber =  Cartridges::getMaxInvNumber();
        $model->inv_number = $invNumber;
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            if(is_null($model->serial)) {
                $model->serial = 'б/н';
            }
            if(is_null($model->supplier_id)) {
                $model->supplier_id = 1;
            }
            if($model->save()){
                return $this->redirect(Url::to(['cartridges/index']));
            }

        }else{
            return $this->render('edit-cartridge', ['model' => $model, 'invNumber' => $invNumber]);
        }
    }
    
    public function actionUpdate(){
        $model = Cartridges::findOne(Yii::$app->request->get('id'));
        $invNumber =  Cartridges::getMaxInvNumber();
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            if(is_null($model->serial)) {
                $model->serial = 'б/н';
            }
            if(is_null($model->supplier_id)) {
                $model->supplier_id = 1;
            }
            if($model->save()){
                return $this->redirect(Url::to(['cartridges/index']));
            }
        }else{
            return $this->render('edit-cartridge', ['model' => $model, 'invNumber' => $invNumber]);
        }
    }
    
    public function actionDelete(){
        Cartridges::deleteCartridge(Yii::$app->request->get('id'));
        return $this->redirect(Url::to(['cartridges/index']));
    }
}

