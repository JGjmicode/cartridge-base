<?php
namespace app\models;
use yii\db\ActiveRecord;

class Supplier extends ActiveRecord{
    public function rules(){
        return [
            [['title'], 'required'],
            [['note'], 'default'],
        ];
    }

    public function attributeLabels(){
        return [
            'title' => 'Поставщик',
            'note' => 'Примечание',
        ];
    }
}