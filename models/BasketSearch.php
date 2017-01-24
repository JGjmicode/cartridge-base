<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Cartridges;
use app\models\Basket;

class BasketSearch extends Basket
{

    
    public static function tableName()
    {
        return 'basket';
    }
    
    public function search($params, $action = false)
    {
        $query = Basket::find();
        if($action == 'send'){
            $query->where(['to_service' => Basket::TO_SERVICE]);
        }
        if($action == 'get'){
            $query->where(['from_service' => Basket::FROM_SERVICE]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 25,

            ],

        ]);
        
        // join with relation `author` that is a relation to the table `users`
        // and set the table alias to be `author`
        $query->joinWith('cartridges');
        
        // enable sorting for the related column
//        $dataProvider->sort->attributes['printersTypes.types'] = [
//            'asc' => ['printersTypes.types' => SORT_ASC],
//            'desc' => ['printersTypes.types' => SORT_DESC],
//        ];
        // load the search form data and validate
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // adjust the query by adding the filters
//        $query->andFilterWhere(['like', 'types', $this->getAttribute('printersTypes.types')])
//              ->andFilterWhere(['like', 'model', $this->getAttribute('model')])
//              ->andFilterWhere(['like', 'serial', $this->getAttribute('serial')])
//              ->andFilterWhere(['like', 'inv_number', $this->getAttribute('inv_number')]);

        

        return $dataProvider;
    }
    
//    public function attributes()
//    {
//    // add related fields to searchable attributes
//    return array_merge(parent::attributes(), ['printersTypes.types']);
//    }
    
//    public function rules()
//    {
//        // only fields in rules() are searchable
//        return [
//            [['printersTypes.types', 'model', 'serial', 'inv_number'], 'safe'],
//
//        ];
//    }

    
    
    
    
}