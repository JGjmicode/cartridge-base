<?php
namespace app\models;
use app\models\Contractor;
use yii\data\ActiveDataProvider;

class ContractorSearch extends Contractor{

    public static function tableName(){
        return 'contractor';
    }

    public function search($params){
        $query = Contractor::find();

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
            ->andFilterWhere(['like', 'person', $this->getAttribute('person')])
            ->andFilterWhere(['like', 'phone', $this->getAttribute('phone')])
            ->andFilterWhere(['like', 'e_mail', $this->getAttribute('e_mail')]);

        return $dataProvider;
    }

    public function rules()
    {
        // only fields in rules() are searchable
        return [
            [['title', 'person', 'phone', 'e_mail'], 'safe'],

        ];
    }
}