<?php
namespace app\models;
use app\models\Supplier;
use yii\data\ActiveDataProvider;

class SupplierSearch extends Supplier{

    public static function tableName(){
        return 'supplier';
    }

    public function search($params){
        $query = Supplier::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'title', $this->getAttribute('title')])
            ->andFilterWhere(['like', 'note', $this->getAttribute('note')]);

        return $dataProvider;
    }

    public function rules()
    {
        // only fields in rules() are searchable
        return [
            [['title', 'note'], 'safe'],

        ];
    }
}