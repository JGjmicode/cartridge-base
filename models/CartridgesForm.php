<?php

namespace app\models;

use Yii;
use yii\base\Model;

class CartridgesForm extends Model{
    public $printer_id;
    public $serial;
    public $inv_number;
    public $model;
    public $note;
    public $resource;
    public $supplier_id;
    public $inv_service;

    public function rules(){
        return [
            [['printer_id', 'model', 'inv_number' ], 'required'],
            [['serial', 'note', 'resource', 'supplier_id', 'inv_service'], 'default'],

        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'printer_id' => 'Типы принтеров',
            'model' => 'Модель',
            'inv_number' => 'Инвентарный номер',
            'serial' => 'Серийный номер',
            'note' => 'Примечание',
            'resource' => 'Ресурс картриджа',
            'supplier_id' => 'Поставщик',
            'inv_service' => 'Инвентарный номер сервиса'
        ];
    }
    
    }