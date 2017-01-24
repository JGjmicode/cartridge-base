<?php
namespace app\models;

use yii\base\Model;

class ContractorForm extends Model{

    public $title;
    public $person;
    public $eMail;
    public $phone;

    public function rules(){
        return [
            [['title', 'person', 'eMail', 'phone'], 'required'],
            [['eMail'], 'email'],
        ];
    }

    public function attributeLabels(){
        return [
            'title' => 'Организация',
            'person' => 'Представитель',
            'eMail' => 'E-Mail',
            'phone' => 'Номер телефона'
        ];
    }

}