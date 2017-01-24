<?php
namespace app\models;
use yii\db\ActiveRecord;

class PrintersTypes extends ActiveRecord{
    
    public function savePrintersTypes($model){
        $this->types = $model->types;
        $this->total = $model->total;
        $this->save();
    }
    
    public static function deletePrinterstypes($id){
        $type = self::findOne($id);
        $type->delete();
    }
}





