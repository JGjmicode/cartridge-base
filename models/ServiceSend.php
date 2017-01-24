<?php
namespace app\models;
use yii\db\ActiveRecord;
use Yii;

class ServiceSend extends ActiveRecord{

    public function getSendAct(){
        return $this->hasMany(SendAct::className(),['act_id' => 'send_act_id']);
    }

    public  function getCustomer(){
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    public function getContractor(){
        return $this->hasOne(Contractor::className(), ['id' => 'contractor_id']);
    }

    public function saveSendAct($model){
        $this->customer_id = $model->customer_id;
        $this->contractor_id = $model->contractor_id;
        $this->create_at = Yii::$app->formatter->asTimestamp($model->create_at);
        $this->save();
    }

}

