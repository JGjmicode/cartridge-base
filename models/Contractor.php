<?php
namespace app\models;
use yii\db\ActiveRecord;

class Contractor extends ActiveRecord{

    public function saveContractor($model){

        $this->title = $model->title;
        $this->person = $model->person;
        $this->e_mail = $model->eMail;
        $this->phone = $model->phone;
        $this->save();

    }

}