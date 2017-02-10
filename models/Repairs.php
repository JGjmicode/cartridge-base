<?php
namespace app\models;

use yii\db\ActiveRecord;

class Repairs extends ActiveRecord{

    public function attributeLabels()
    {
        return [
            'model' => 'Модель принтера',
            'invNumber' => 'Инвентраный номер',
            'cabinet' => '№ кабинета',
            'problem' => 'Неисправность',
            'note' => 'Примечание'
        ];
    }

    public function rules()
    {
        return [
            [['model', 'invNumber', 'problem'], 'required'],
            [['note', 'cabinet'], 'default']
        ];
    }

}