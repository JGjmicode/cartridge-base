<?php
namespace app\models;

use yii\base\Model;

class CustomerForm extends Model{

    public $name;
    public $nameRP;
    public $position;

    public function rules(){
        return [
            [['name', 'nameRP', 'position'], 'required'],
        ];
    }

    public function attributeLabels(){
        return [
            'name' => 'Ф.И.О',
            'nameRP' => 'Ф.И.О в род.падеже',
            'position' => 'Должность',
        ];
    }

}