<?php
namespace app\models;
use yii\db\ActiveRecord;
use app\models\Cartridges;

class Basket extends ActiveRecord{

    const TO_SERVICE = 1;
    const FROM_SERVICE = 1;

    public function getCartridges(){
        return $this->hasOne(Cartridges::className(), ['id' => 'cartridge_id']);
    }

    public function addCartridgeToBasket($model, $action){
            if($action == 'send') {
                $this->problem = $model->problem;
                $this->to_service = true;
                if(!is_null($model->departament_id)){
                    $this->departament_id = $model->departament_id;
                }else{
                    $this->departament_id = 1;
                }
            }
            if($action == 'get'){
                $this->works = $model->works;
                $this->from_service = true;
            }
            $this->komplekt = $model->komplekt;
            $this->weidth = $model->weidth;
            $this->cartridge_id = $model->cartridge_id;
            $this->save();
            $cartridge = Cartridges::findOne($model->cartridge_id);
            $cartridge->basket = true;
            $cartridge->save();
    }

    public static function deleteFromBasket($id = NULL){
        if (!is_null($id)){
            $cart = self::findOne($id);
            $cart->delete();
            $cartridge = Cartridges::findOne($cart->cartridge_id);
            $cartridge->basket = false;
            $cartridge->save();
        }
    }

    public static function editCartridgeInBasket($model, $action){
        $cart = self::findOne($model->cartridge_id);
        if($action == 'send') {
            $cart->problem = $model->problem;
            if(!is_null($model->departament_id)){
                $cart->departament_id = $model->departament_id;
            }
        }
        if($action == 'get'){
            $cart->works = $model->works;
        }
        $cart->komplekt = $model->komplekt;
        $cart->weidth = $model->weidth;
        $cart->save();
    }

}

