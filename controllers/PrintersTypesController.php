<?php

namespace app\controllers;
use yii\web\Controller;
use app\models\PrintersTypesSearch;
use Yii;
use app\models\PrintersTypesForm;
use app\models\PrintersTypes;
use yii\helpers\Url;
use yii\db\Query;
use app\controllers\BehaviorsController;

class PrintersTypesController extends BehaviorsController
{
    public function actionIndex(){
            $searchModel = new PrintersTypesSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->get());
            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]);
    }
    
    public function actionAdd(){
        $model = new PrintersTypes;
        if($model->load(Yii::$app->request->post()) && $model->save()){
            return $this->redirect(Url::to(['printers-types/index']));
        }else{
            return $this->render('edit-types', ['model' => $model]);
        }
    }
    
    public function actionUpdate(){
        $model = PrintersTypes::findOne(Yii::$app->request->get('id'));
        if($model->load(Yii::$app->request->post()) && $model->save()){
            return $this->redirect(Url::to(['printers-types/index']));
        }else{
            return $this->render('edit-types', ['model' => $model]);
        }
    }
    
    public function actionDelete(){
        $model = PrintersTypes::findOne(Yii::$app->request->get('id'));
        $model->delete();
        return $this->redirect(Url::to(['printers-types/index']));
    }
    
    public function actionGetTypes($q = null, $id = null){
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $out = ['results' => ['id' => '', 'text' => '']];
    if (!is_null($q)) {
        $query = new Query;
        $query->select('id, types AS text')
            ->from('printers_types')
            ->where(['like', 'types', $q])
            ->limit(20);
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out['results'] = array_values($data);
    }
    elseif ($id > 0) {
        $out['results'] = ['id' => $id, 'text' => PrintersTypes::find($id)->types];
    }
    return $out;
    }
    
}
