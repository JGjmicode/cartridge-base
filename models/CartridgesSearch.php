<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Cartridges;

class CartridgesSearch extends Cartridges
{
    public $location;

    
    public static function tableName()
    {
        return 'cartridges';
    }
    
    public function search($params, $basket = false, $service = false)
    {
        $query = Cartridges::find()->where(['status' => Cartridges::STATUS_ACTIVE]);
        if($service == 'send') {
            $query->andWhere(['service' => Cartridges::STATUS_STORAGE]);
        }
        if($service == 'get') {
            $query->andWhere(['service' => Cartridges::STATUS_SERVICE]);
        }
        if($basket) {
            $query->andWhere(['basket' => Cartridges::STATUS_BASKET]);
        }


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 25,
                'pageParam' => 'cartridge-page'
            
            ],
            'sort' => [
                'sortParam' => 'cartridge-sort',
                'defaultOrder' => [
                    'inv_number' => SORT_ASC
                ]

                ]
            ]);
        
        // join with relation `author` that is a relation to the table `users`
        // and set the table alias to be `author`
        $query->joinWith('printersTypes');
        $query->joinWith('supplier');

        // enable sorting for the related column
        $dataProvider->sort->attributes['printersTypes.types'] = [
            'asc' => ['printersTypes.types' => SORT_ASC],
            'desc' => ['printersTypes.types' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['supplier.title'] = [
            'asc' => ['supplier.title' => SORT_ASC],
            'desc' => ['supplier.title' => SORT_DESC],
        ];
        // load the search form data and validate
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // adjust the query by adding the filters
        $query->andFilterWhere(['like', 'types', $this->getAttribute('printersTypes.types')])
              ->andFilterWhere(['like', 'model', $this->getAttribute('model')])
              ->andFilterWhere(['like', 'serial', $this->getAttribute('serial')])
              ->andFilterWhere(['like', 'inv_number', $this->getAttribute('inv_number')])
              ->andFilterWhere(['like', 'inv_service', $this->getAttribute('inv_service')])
              ->andFilterWhere(['like', 'supplier.title', $this->getAttribute('supplier.title')])
              ->andFilterWhere(['like', 'service', $this->location]);


        return $dataProvider;
    }
    
    public function attributes()
    {
    // add related fields to searchable attributes
    return array_merge(parent::attributes(), ['printersTypes.types', 'supplier.title']);
    }
    
    public function rules()
    {
        // only fields in rules() are searchable
        return [
            [['printersTypes.types', 'model', 'serial', 'inv_number', 'supplier.title', 'location', 'inv_service'], 'safe'],

        ];
    }

    
    
    
    
}