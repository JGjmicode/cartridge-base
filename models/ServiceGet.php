<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class ServiceGet extends ActiveRecord{

    public  function getCustomer(){
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    public function getContractor(){
        return $this->hasOne(Contractor::className(), ['id' => 'contractor_id']);
    }

    public function getGetAct(){
        return $this->hasMany(GetAct::className(),['act_id' => 'get_act_id']);
    }

    public function saveGetAct($model){
        $this->customer_id = $model->customer_id;
        $this->contractor_id = $model->contractor_id;
        $this->create_at = Yii::$app->formatter->asTimestamp($model->create_at);
        $this->save();
    }
}