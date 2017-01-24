<?php
namespace app\models;
use yii\base\Model;

class DepartamentsEditForm extends Model{

    public $name;
    public $cabinet;
    public $printerTypesId;

    public function rules(){
        return [
            [['name'], 'required'],
            [['cabinet', 'printerTypesId'], 'default'],
        ];
    }

    public function attributeLabels(){
        return [
            'name' => 'Название отдела',
            'cabinet' => 'Номер кабинета',
            'printerTypesId' => 'Тип принтера',
        ];
    }
}