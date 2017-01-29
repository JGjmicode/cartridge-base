<?php
namespace app\models;
use yii\db\ActiveRecord;

class Departaments extends ActiveRecord{

    public function getPrintersTypes(){
        return $this->hasOne(PrintersTypes::className(), ['id' => 'printer_types_id']);
    }

    public function rules(){
        return [
            [['name'], 'required'],
            [['cabinet', 'printer_types_id'], 'default'],
        ];
    }

    public function attributeLabels(){
        return [
            'name' => 'Название отдела',
            'cabinet' => 'Номер кабинета',
            'printer_types_id' => 'Тип принтера',
        ];
    }
}