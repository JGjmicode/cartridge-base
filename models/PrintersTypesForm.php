<?php

namespace app\models;

use Yii;
use yii\base\Model;

class PrintersTypesForm extends Model{
    public $types;
    public $total;

    public function rules(){
        return [
            [['types'], 'required'],
            [['total'], 'integer', 'message' => 'Введите число'],
            //[['total'], 'default'],

        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'types' => 'Типы принтеров',
            'total' => 'Количество картриджей',
        ];
    }
    
    }