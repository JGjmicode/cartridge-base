<?php
namespace app\models;
use yii\db\ActiveRecord;

class Cartridges extends ActiveRecord{
    
    const STATUS_ACTIVE = 1;
    const STATUS_BASKET = 0;
    const STATUS_SERVICE = 1;
    const STATUS_STORAGE = 0;

    
    public function getPrintersTypes(){
        return $this->hasOne(PrintersTypes::className(), ['id' => 'printer_id']);
    }

    public function getSupplier(){
        return $this->hasOne(Supplier::className(),['id' => 'supplier_id']);
    }


    public function saveCartridge($model){
        $this->model = $model->model;
        $this->printer_id = $model->printer_id;
        if(!is_null($model->serial)) {
            $this->serial = $model->serial;
        }else{
            $this->serial = 'б/н';
        }
        $this->inv_number = $model->inv_number;
        $this->inv_service = $model->inv_service;
        if(is_null($model->supplier_id)){
            $this->supplier_id = 1;
        }else{
            $this->supplier_id = $model->supplier_id;
        }
        $this->note = $model->note;
        if(!is_null($model->resource)) {
            $this->resource = $model->resource;
        }else{
            $this->resource = 0;
        }
        $this->save();
    }
    
    public static function deleteCartridge($id = NULL){
        if(!is_null($id)){
            $cartridge = self::findOne($id);
            $cartridge->status = false;
            $cartridge->save();
        }
    }

    public static function getMaxInvNumber(){
        $invNumber = self::find();
        return $invNumber->max('inv_number') + 1;
    }
}

