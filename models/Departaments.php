<?php
namespace app\models;
use yii\db\ActiveRecord;

class Departaments extends ActiveRecord{

    public function getPrintersTypes(){
        return $this->hasOne(PrintersTypes::className(), ['id' => 'printer_types_id']);
    }

    public function editDepartament($model){
        $this->name = $model->name;
        $this->cabinet = $model->cabinet;
        $this->printer_types_id = $model->printerTypesId;
        $this->save();

    }

    public static function deleteDepartament($id){
        $departament = self::findOne($id);
        $departament->delete();
    }
}