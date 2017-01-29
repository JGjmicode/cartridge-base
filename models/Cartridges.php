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


    public static function deleteCartridge($id = NULL){
        if(!is_null($id)){
            $cartridge = self::findOne($id);
            $cartridge->status = false;
            $cartridge->save();
        }
    }

    public function rules(){
        return [
            [['printer_id', 'model', 'inv_number' ], 'required'],
            [['serial', 'note', 'resource', 'supplier_id', 'inv_service'], 'default'],

        ];
    }


    public function attributeLabels()
    {
        return [
            'printer_id' => 'Типы принтеров',
            'model' => 'Модель',
            'inv_number' => 'Инвентарный номер',
            'serial' => 'Серийный номер',
            'note' => 'Примечание',
            'resource' => 'Ресурс картриджа',
            'supplier_id' => 'Поставщик',
            'inv_service' => 'Инвентарный номер сервиса'
        ];
    }

    public static function getMaxInvNumber(){
        $invNumber = self::find();
        return $invNumber->max('inv_number') + 1;
    }
}

