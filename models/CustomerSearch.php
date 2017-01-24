<?php
namespace app\models;
use app\models\Customer;
use yii\data\ActiveDataProvider;

class CustomerSearch extends Customer{

    public static function tableName(){
        return 'customer';
    }

    public function search($params){
        $query = Customer::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'name', $this->getAttribute('name')])
            ->andFilterWhere(['like', 'nameRP', $this->getAttribute('nameRP')])
            ->andFilterWhere(['like', 'position', $this->getAttribute('position')]);

        return $dataProvider;
    }

    public function rules()
    {
        // only fields in rules() are searchable
        return [
            [['nameRP', 'name', 'position'], 'safe'],

        ];
    }
}