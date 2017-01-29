<?php
namespace app\models;
use yii\db\ActiveRecord;

class PrintersTypes extends ActiveRecord{

    public function rules(){
        return [
            [['types'], 'required'],
            [['total'], 'integer', 'message' => 'Введите число'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'types' => 'Типы принтеров',
            'total' => 'Количество картриджей',
        ];
    }

}





