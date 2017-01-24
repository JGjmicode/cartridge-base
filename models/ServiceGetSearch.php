<?php
namespace app\models;
use yii\data\ActiveDataProvider;
use app\models\ServiceGet;
use Yii;

class ServiceGetSearch extends ServiceGet{

    public $date_from;
    public $date_to;

    public static function tableName(){
        return 'service_get';
    }

    public function search($params)
    {
        $query = ServiceGet::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 25,
            ],
            'sort' => [
                'defaultOrder' => [
                    'get_act_id' => SORT_DESC
                ]
            ]
        ]);

        $query->joinWith('getAct');

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // adjust the query by adding the filters

        $query->andFilterWhere(['like', 'get_act_id', $this->getAttribute('get_act_id')])
            ->andFilterWhere(['>=', 'service_get.create_at', Yii::$app->formatter->asTimestamp($this->date_from) ]);
        if($this->date_to != ''){
            $query->andFilterWhere(['<=', 'service_get.create_at', Yii::$app->formatter->asTimestamp($this->date_to) + 86399 ]);
        }

        return $dataProvider;
    }

    public function rules()
        {
            // only fields in rules() are searchable
            return [
                [['get_act_id', 'create_at'], 'safe'],
                [['date_from', 'date_to'], 'date', 'format' => 'php:d.m.Y'],

            ];
        }

}