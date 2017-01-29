<?php
namespace app\controllers;

use app\models\Contractor;
use app\models\ContractorForm;
use app\models\ContractorSearch;
use yii\web\Controller;
use Yii;
use yii\helpers\Url;
use app\controllers\BehaviorsController;

class ContractorController extends BehaviorsController{

    public function actionIndex(){
        $searchModel = new ContractorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        return $this->render('index',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAdd(){
        $model = new Contractor();
        if($model->load(Yii::$app->request->post()) && $model->save()){
            return $this->redirect(Url::to(['/contractor/index' ]));
        }
        return $this->render('edit', [
            'model' => $model
        ]);
    }

    public function actionUpdate(){
        $model = Contractor::findOne(Yii::$app->request->get('id'));
        if($model->load(Yii::$app->request->post()) && $model->save()){
            return $this->redirect(Url::to(['/contractor/index' ]));
        }
        return $this->render('edit', [
            'model' => $model
        ]);
    }

    public function actionDelete(){
        $model = Contractor::findOne(Yii::$app->request->get('id'));
        $model->delete();
        return $this->redirect(Url::to(['/contractor/index' ]));
    }

}