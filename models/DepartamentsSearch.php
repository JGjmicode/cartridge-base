<?php
namespace app\models;
use yii\data\ActiveDataProvider;
use app\models\Departaments;

class DepartamentsSearch extends Departaments{

    public static function tableName(){
        return 'departaments';
    }

    public function search($params){
        $query = Departaments::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        $query->joinWith('printersTypes');

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // adjust the query by adding the filters

        $query->andFilterWhere(['like', 'cabinet', $this->getAttribute('cabinet')])
            ->andFilterWhere(['like', 'name', $this->getAttribute('name')])
            ->andFilterWhere(['like', 'types', $this->getAttribute('printersTypes.types')]);

        return $dataProvider;
    }

    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['printersTypes.types']);
    }

    public function rules()
    {
        // only fields in rules() are searchable
        return [
            [['cabinet', 'name', 'printersTypes.types'], 'safe'],

        ];
    }


}