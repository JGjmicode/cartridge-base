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
        $model = new ContractorForm();
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $contractor = new Contractor();
            $contractor->saveContractor($model);
            return $this->redirect(Url::to(['/contractor/index' ]));
        }
        return $this->render('edit', [
            'model' => $model
        ]);
    }

    public function actionUpdate(){
        $model = new ContractorForm();
        $contractor = Contractor::findOne(Yii::$app->request->get('id'));
        $model->title = $contractor->title;
        $model->person = $contractor->person;
        $model->eMail = $contractor->e_mail;
        $model->phone = $contractor->phone;
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $contractor->saveContractor($model);
            return $this->redirect(Url::to(['/contractor/index' ]));
        }
        return $this->render('edit', [
            'model' => $model
        ]);
    }

}