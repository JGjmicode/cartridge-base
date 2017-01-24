<?php
namespace app\controllers;
use app\controllers\BehaviorsController;
use app\models\Cartridges;
use app\models\CartridgesSearch;
use app\models\ReportDepartamentSearch;
use app\models\SendAct;
use app\models\SendActSearch;
use Yii;
use yii\helpers\Url;
use app\models\ActToExcel;

class ReportsController extends BehaviorsController{

    public function actionDepartamentReport(){
        $searchModel = new ReportDepartamentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        return $this->render('departament-report', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCartridgeReport(){
        $cartId = Yii::$app->request->get('id');
        if($cartId == ''){
            $searchModel = new CartridgesSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->get());
            return $this->render('select-cartridge', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else{
            $cartridge = Cartridges::findOne($cartId);
            $searchModel = new SendActSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->get(), false, $cartId);
            return $this->render('cartridge-report', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'cartridge' => $cartridge,
            ]);
        }
    }

    public  function actionLocationReport(){
        $searchModel = new CartridgesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        return $this->render('location-report', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionReportToExcel(){
        ActToExcel::saveReportPlace();
        return $this->redirect(Url::to(['/reports/location-report']));
    }


}