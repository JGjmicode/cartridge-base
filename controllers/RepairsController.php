<?php
namespace app\controllers;
use app\models\ActToExcel;
use app\models\Repairs;
use Yii;
use app\models\RepairsSearch;
use yii\helpers\Url;

class RepairsController extends BehaviorsController{

    public function actionIndex(){
        $searchModel = new RepairsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
    }

    public function actionAdd(){
        $model = new Repairs();
        file_put_contents('post.txt', var_export(Yii::$app->request->post(), true));
        if($model->load(Yii::$app->request->post()) && $model->save()){
            $this->redirect(Url::to(['/repairs/index']));
        }
        return $this->render('add', ['model' => $model]);

    }

    public function actionUpdate(){
        $id = Yii::$app->request->get('id');
        if(!is_null($id)){
            $model = Repairs::findOne($id);
            if($model->load(Yii::$app->request->post()) && $model->save()){
                $this->redirect(Url::to(['/repairs/index']));
            }else{
                return $this->render('update', ['model' => $model]);
            }
        }else {
            $this->redirect(Url::to(['/repairs/index']));
        }
    }

    public function actionDelete(){
        $id = Yii::$app->request->get('id');
        if(!is_null($id)){
            $model = Repairs::findOne($id);
            if($model->delete()){
                $this->redirect(Url::to(['/repairs/index']));
            }
        }else {
            $this->redirect(Url::to(['/repairs/index']));
        }
    }

    public function actionSaveRepairs(){
        ActToExcel::saveRepairsReport();
    }
}