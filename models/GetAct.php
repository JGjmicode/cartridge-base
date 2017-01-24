<?php
namespace app\models;
use yii\db\ActiveRecord;
use app\models\Basket;
use app\models\ServiceGet;
use app\models\Cartridges;
use app\models\SendAct;

class GetAct extends ActiveRecord{

    public function getCartridges(){
        return $this->hasOne(Cartridges::className(), ['id' => 'cartridge_id']);
    }

    public function getServiceSend(){
        return $this->hasOne(ServiceSend::className(), ['send_act_id' => 'send_act_id']);
    }

    public static function getMaxActId(){
        $actId = self::find();
        return $actId->max('act_id');
    }

    public static function getFromService(){
        $basket = Basket::find()->where(['from_service' => Basket::FROM_SERVICE])->all();
        $act_id = self::getMaxActId() + 1;
        foreach($basket as $cartridge) {
            $sendAct = SendAct::find()->where(['cartridge_id' => $cartridge->cartridge_id])->orderBy(['id' => SORT_DESC])->limit(1)->one();
            $getAct = new GetAct();
            $getAct->act_id = $act_id;
            $getAct->cartridge_id = $cartridge->cartridge_id;
            $getAct->works = $cartridge->works;
            $getAct->weidth = $cartridge->weidth;
            $getAct->komplekt = $cartridge->komplekt;
            $getAct->send_act_id = $sendAct->act_id;
            $getAct->create_at = time();
            $status = $getAct->save();
            if($status){
                Basket::deleteAll(['id' => $cartridge->id]);
                $cart = Cartridges::findOne($cartridge->cartridge_id);
                $cart->basket = false;
                $cart->service = false;
                $cart->save();
            }
        }
        $get = new ServiceGet();
        $get->get_act_id = $act_id;
        $get->create_at = time();
        $get->save();
        return $act_id;
    }
}