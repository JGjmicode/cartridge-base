<?php
namespace app\models;
use yii\db\ActiveRecord;

class Customer extends ActiveRecord{

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