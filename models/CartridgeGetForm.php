<?php

namespace app\models;

use Yii;
use yii\base\Model;

class CartridgeGetForm extends Model{

    public $works;
    public $weidth;
    public $komplekt;
    public $cartridge_id;

    public function rules(){
        return [
            [['works'], 'required'],
            [['weidth', 'komplekt', 'cartridge_id'], 'default'],

        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'works' => 'Выполненые работы',
            'weidth' => 'Вес',
            'komplekt' => 'Комплект',

        ];
    }

}