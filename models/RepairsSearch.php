<?php
namespace app\models;

use yii\data\ActiveDataProvider;

class RepairsSearch extends Repairs{

    public static function tableName(){
        return 'repairs';
    }

    public function search($params){
        $query = Repairs::find();
        $dataProvider = new ActiveDataProvider([
           'query' => $query,
            'pagination' => [
                'pageSize' => 20
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'invNumber', $this->invNumber])
            ->andFilterWhere(['like', 'cabinet', $this->cabinet])
            ->andFilterWhere(['like', 'problem', $this->problem]);

        return $dataProvider;
    }

    public function rules()
    {
        return [
            [['note', 'problem', 'model', 'invNumber', 'cabinet'], 'safe']
        ];
    }

}