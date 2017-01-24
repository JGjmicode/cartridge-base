<?php
namespace app\models;
use yii\data\ActiveDataProvider;
use app\models\SendAct;
use Yii;

class ReportDepartamentSearch extends SendAct{

    public $departament_id;
    public $date_from;
    public $date_to;

    public static function tableName(){
        return 'send_act';
    }

    public function search($params){

        $query = SendAct::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ]
        ]);

        $query->joinWith('serviceSend');
        $query->joinWith('cartridges');

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'departament_id', $this->departament_id])
            ->andFilterWhere(['>=', 'service_send.create_at', Yii::$app->formatter->asTimestamp($this->date_from) ]);

        if($this->date_to != ''){
            $query->andFilterWhere(['<=', 'service_send.create_at', Yii::$app->formatter->asTimestamp($this->date_to) + 86399 ]);
        }

        return $dataProvider;

    }

    public function rules()
    {
        // only fields in rules() are searchable
        return [
            [['departament_id', 'date_from', 'date_to'], 'safe'],

        ];
    }

}