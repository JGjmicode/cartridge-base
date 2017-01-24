<?php

namespace app\models;

use Yii;
use yii\base\Model;

class CartridgeSendForm extends Model{
    
    public $problem;
    public $weidth;
    public $komplekt;
    public $cartridge_id;
    public $departament_id;

    public function rules(){
        return [
            [['problem'], 'required'],
            [['weidth', 'komplekt', 'cartridge_id', 'departament_id'], 'default'],

        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'problem' => 'Неисправность',
            'weidth' => 'Вес',
            'komplekt' => 'Комплект',
            'departament_id' => 'Отдел',

        ];
    }
    
    }