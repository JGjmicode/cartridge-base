<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PrintersTypes;

class PrintersTypesSearch extends PrintersTypes
{

    
    public static function tableName()
    {
        return 'printers_types';
    }
    
    public function search($params)
    {
        $query = PrintersTypes::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 25,
        ]]);
        
        // join with relation `author` that is a relation to the table `users`
        // and set the table alias to be `author`

        // enable sorting for the related column
        $dataProvider->sort->attributes['types'] = [
            'asc' => ['types' => SORT_ASC],
            'desc' => ['types' => SORT_DESC],
        ];
        // load the search form data and validate
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // adjust the query by adding the filters
        $query->andFilterWhere(['like', 'types', $this->getAttribute('types')]);

        

        return $dataProvider;
    }
    
    public function attributes()
    {
    // add related fields to searchable attributes
    return array_merge(parent::attributes(), ['types']);
    }
    
    public function rules()
    {
        // only fields in rules() are searchable
        return [
            [['types'], 'safe'],

        ];
    }

    
    
    
    
}