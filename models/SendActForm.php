<?php
namespace app\models;
use yii\base\Model;

class SendActForm extends Model{

    public $customer_id;
    public $contractor_id;
    public  $create_at;

    public function rules(){
        return [
            [['customer_id', 'contractor_id', 'create_at'], 'required'],
        ];
    }

    public function attributeLabels(){
        return [
            'customer_id' => 'Заказчик',
            'contractor_id' => 'Исполнитель',
            'create_at' => 'Дата и время акта',
        ];
    }

}