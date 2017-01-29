<?php
namespace app\controllers;

use app\models\Departaments;
use yii\web\Controller;
use Yii;
use yii\helpers\Url;
use app\models\DepartamentsSearch;
use app\models\DepartamentsEditForm;
use app\models\PrintersTypesForm;
use yii\db\Query;
use app\controllers\BehaviorsController;

class DepartamentsController extends BehaviorsController{

    public function actionIndex(){
        $departamentsSearchModel = new DepartamentsSearch();
        $dataProvider = $departamentsSearchModel->search(Yii::$app->request->get());
        return $this->render('index',[
            'searchModel' => $departamentsSearchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAdd(){
        $model = new Departaments();
        if($model->load(Yii::$app->request->post()) && $model->save()){
            return $this->redirect(['/departaments/index']);
        }
        return $this->render('edit', [
            'model' => $model,
        ]);
    }

    public function actionUpdate(){
        $model = Departaments::findOne(Yii::$app->request->get('id'));
        if($model->load(Yii::$app->request->post()) && $model->save()){
            return $this->redirect(['/departaments/index']);
        }
        return $this->render('edit',[
            'model' => $model,
        ]);
    }

    public function actionDelete(){
        $model = Departaments::findOne(Yii::$app->request->get('id'));
        $model->delete();
        return $this->redirect(['/departaments/index']);

    }

    public function actionGetDepartament($q = null, $id = null){

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, name AS text')
                ->from('departaments')
                ->where(['like', 'name', $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Departaments::findOne($id)->name];
        }
        return $out;

    }


}
