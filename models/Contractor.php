<?php
namespace app\models;
use yii\db\ActiveRecord;

class Contractor extends ActiveRecord{

    public function rules(){
        return [
            [['title', 'person', 'e_mail', 'phone'], 'required'],
            [['e_mail'], 'email'],
        ];
    }

    public function attributeLabels(){
        return [
            'title' => 'Организация',
            'person' => 'Представитель',
            'e_mail' => 'E-Mail',
            'phone' => 'Номер телефона'
        ];
    }

}