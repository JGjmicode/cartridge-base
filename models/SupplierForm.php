<?php
namespace app\models;

use yii\base\Model;

class SupplierForm extends Model{

    public $title;
    public $note;


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