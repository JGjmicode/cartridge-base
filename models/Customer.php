<?php
namespace app\models;
use yii\db\ActiveRecord;

class Customer extends ActiveRecord{

    public function saveCustomer($model){

        $this->name = $model->name;
        $this->nameRP = $model->nameRP;
        $this->position = $model->position;
        $this->save();

    }

}