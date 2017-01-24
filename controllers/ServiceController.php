<?php
namespace app\controllers;

use app\models\ActToExcel;
use app\models\CartridgeGetForm;
use app\models\GetAct;
use app\models\GetActSearch;
use app\models\SendActForm;
use app\models\SendActSearch;
use app\models\ServiceSend;
use app\models\ServiceGet;
use app\models\ServiceGetSearch;
use app\models\ServiceSendSearch;
use yii\helpers\Url;
use yii\web\Controller;
use yii;
use app\models\CartridgeSendForm;
use app\models\CartridgesSearch;
use yii\helpers\Html;
use app\models\BasketSearch;
use app\models\SendAct;
use app\models\Basket;
use app\controllers\BehaviorsController;



class ServiceController extends BehaviorsController{
    
    public function actionSend(){
        $ServiceSendSearchModel = new ServiceSendSearch();
        $ServiceSendProvider = $ServiceSendSearchModel->search(Yii::$app->request->get());
        return $this->render('send', [
            'ServiceSendSearchModel' => $ServiceSendSearchModel,
            'ServiceSendProvider' => $ServiceSendProvider,
        ]);
    }

    public function actionGet(){
        $serviceGetSearchModel = new ServiceGetSearch();
        $serviceGetProvider = $serviceGetSearchModel->search(Yii::$app->request->get());
        return $this->render('get', [
            'searchModel' => $serviceGetSearchModel,
            'dataProvider' => $serviceGetProvider
        ]);
    }
    
    public function actionNewSend(){
        $model = new CartridgeSendForm();
        $model->komplekt = 'Картридж + чип';
        $CartridgeSearchModel = new CartridgesSearch();
        $CartridgeProvider = $CartridgeSearchModel->search(Yii::$app->request->get(), true, 'send');
        $basket = new Basket();
        $getBasket = $basket->find()->where(['to_service' => Basket::TO_SERVICE])->all();
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $basket->addCartridgeToBasket($model, 'send');
        }
        return $this->render('cartridge-send', [
                'model' => $model,
                'CartridgeProvider' => $CartridgeProvider,
                'CartridgeSearchModel' => $CartridgeSearchModel,
                'basket' => $getBasket,
            ]);
    }

    public function actionNewGet(){
        $model = new CartridgeGetForm();
        $CartridgeSearchModel = new CartridgesSearch();
        $CartridgeProvider = $CartridgeSearchModel->search(Yii::$app->request->get(), true, 'get');
        $basket = new Basket();
        $getBasket = $basket->find()->where(['from_service' => Basket::FROM_SERVICE])->all();
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $basket->addCartridgeToBasket($model, 'get');
        }
        return $this->render('cartridge-get', [
            'model' => $model,
            'CartridgeProvider' => $CartridgeProvider,
            'CartridgeSearchModel' => $CartridgeSearchModel,
            'basket' => $getBasket,
        ]);
    }

    public function actionNewSendAct(){
        $model = new CartridgeSendForm();
        $BasketSearchModel = new BasketSearch();
        $BasketProvider = $BasketSearchModel->search(Yii::$app->request->get(), 'send');
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            Basket::editCartridgeInBasket($model, 'send');
        }
        return $this->render('send-act', [
            'model' => $model,
            'BasketSearchModel' => $BasketSearchModel,
            'BasketProvider' => $BasketProvider,

        ]);
    }

    public function actionNewGetAct(){
        $model = new CartridgeGetForm();
        $BasketSearchModel = new BasketSearch();
        $BasketProvider = $BasketSearchModel->search(Yii::$app->request->get(), 'get');
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            Basket::editCartridgeInBasket($model, 'get');
        }
        return $this->render('get-act', [
            'model' => $model,
            'BasketSearchModel' => $BasketSearchModel,
            'BasketProvider' => $BasketProvider,
        ]);
    }

    public function actionViewSendAct(){
        $model = new SendActForm();
        $act_id = Yii::$app->request->get('act_id');
        $SendActSearchModel = new SendActSearch();
        $SendActProvider = $SendActSearchModel->search(Yii::$app->request->get(), $act_id);
        $serviceSend = ServiceSend::find()->where(['send_act_id' => $act_id])->one();
        $model->customer_id = $serviceSend->customer_id;
        $model->contractor_id = $serviceSend->contractor_id;
        $model->create_at = Yii::$app->formatter->asDateTime($serviceSend->create_at, 'php:d-m-Y H:i');
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $serviceSend->saveSendAct($model);
        }
        return $this->render('view-send-act', [
            'model' => $model,
            'SendActSearchModel' => $SendActSearchModel,
            'SendActProvider' => $SendActProvider,
            'serviceSend' => $serviceSend
        ]);
    }

    public function actionViewGetAct(){
        $model = new SendActForm();
        $act_id = Yii::$app->request->get('act_id');
        $searchModel = new GetActSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get(), $act_id);
        $serviceGet = ServiceGet::find()->where(['get_act_id' => $act_id])->one();
        $model->customer_id = $serviceGet->customer_id;
        $model->contractor_id = $serviceGet->contractor_id;
        $model->create_at = Yii::$app->formatter->asDateTime($serviceGet->create_at, 'php:d-m-Y H:i');
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $serviceGet->saveGetAct($model);
        }
        return $this->render('view-get-act',[
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'serviceGet' => $serviceGet,
        ]);
    }

    public function actionSendToService(){
        $act_id = SendAct::sendToService();
        return $this->redirect(Url::to(['/service/view-send-act', 'act_id' => $act_id ]));
    }

    public function actionGetFromService(){
        $act_id = GetAct::getFromService();
        return $this->redirect(Url::to(['/service/view-get-act', 'act_id' => $act_id ]));

    }

    public function actionDelete(){
        Basket::deleteFromBasket(Yii::$app->request->get('id'));
        if(Yii::$app->request->get('action') == 'send') {
            return $this->redirect(Url::to(['/service/new-send-act']));
        }
        if(Yii::$app->request->get('action') == 'get') {
            return $this->redirect(Url::to(['/service/new-get-act']));
        }
    }

    public function actionSendExcel(){
        $act_id = Yii::$app->request->get('act_id');
        ActToExcel::saveSendActToExcel($act_id);
        return $this->redirect(Url::to(['/service/view-send-act', 'act_id' => $act_id ]));
    }

    public function actionGetExcel(){
        $act_id = Yii::$app->request->get('act_id');
        ActToExcel::saveGetActToExcel($act_id);
        return $this->redirect(Url::to(['/service/view-get-act', 'act_id' => $act_id ]));
    }
}