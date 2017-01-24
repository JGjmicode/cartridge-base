<?php
namespace app\models;
use yii\db\ActiveRecord;
use app\models\Basket;
use app\models\Cartridges;
use app\models\ServiceSend;

class SendAct extends ActiveRecord{

    public function getCartridges(){
        return $this->hasOne(Cartridges::className(), ['id' => 'cartridge_id']);
    }

    public function getServiceSend(){
        return $this->hasOne(ServiceSend::className(),['send_act_id' => 'act_id']);
    }
    
    public function addCartridgeToSendAct($model){
        //$this->problem = $model->problem;
        //$this->komplekt = $model->komplekt;
        //$this->weidth = $model->weidth;
        //$this->act_id = '1';
        //$this->cartridge_id = $model->cartridge_id;
        //$this->save();
    }

    public static function getMaxActId(){
        $actId = self::find();
        return $actId->max('act_id');
    }

    public static function sendToService(){
        $basket = Basket::find()->where(['to_service' => Basket::TO_SERVICE])->all();
        $act_id = self::getMaxActId() + 1;
        foreach($basket as $cartridge) {
            $sendAct = new SendAct();
            $sendAct->act_id = $act_id;
            $sendAct->cartridge_id = $cartridge->cartridge_id;
            $sendAct->problem = $cartridge->problem;
            $sendAct->weidth = $cartridge->weidth;
            $sendAct->komplekt = $cartridge->komplekt;
            $sendAct->departament_id = $cartridge->departament_id;
            $sendAct->create_at = time();

            $status = $sendAct->save();
            if($status){
                Basket::deleteAll(['id' => $cartridge->id]);
                $cart = Cartridges::findOne($cartridge->cartridge_id);
                $cart->basket = false;
                $cart->service = true;
                $cart->save();
            }
        }
        $send = new ServiceSend();
        $send->send_act_id = $act_id;
        $send->create_at = time();
        $send->save();
        return $act_id;
    }
}

