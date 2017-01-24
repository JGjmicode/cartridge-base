<?php
namespace app\models;
use yii\db\ActiveRecord;

class Supplier extends ActiveRecord{

    public function saveSupplier($model){

        $this->title = $model->title;
        $this->note = $model->note;
        $this->save();

    }

}