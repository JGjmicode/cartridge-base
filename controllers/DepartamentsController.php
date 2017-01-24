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
        $model = new DepartamentsEditForm();
        //$model = new PrintersTypesForm();
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $departament = new Departaments();
            $departament->editDepartament($model);
            return $this->redirect(['/departaments/index']);
        }
        return $this->render('edit', [
            'model' => $model,
        ]);
    }

    public function actionUpdate(){
        $model = new DepartamentsEditForm();
        $id = Yii::$app->request->get('id');
        $departament = Departaments::findOne($id);
        $model->name = $departament->name;
        $model->cabinet = $departament->cabinet;
        $model->printerTypesId = $departament->printer_types_id;
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $departament->editDepartament($model);
            return $this->redirect(['/departaments/index']);
        }
        return $this->render('edit',[
            'model' => $model,
        ]);
    }

    public function actionDelete(){
        $id = Yii::$app->request->get('id');
        Departaments::deleteDepartament($id);
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
