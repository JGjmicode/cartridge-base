<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SendAct;
use app\models\ServiceSend;

class ServiceSendSearch extends ServiceSend
{
    public $date_from;
    public $date_to;

    public static function tableName()
    {
        return 'service_send';
    }

    public function search($params)
    {
        $query = ServiceSend::find();


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 25,
            ],
            'sort' => [
                'defaultOrder' => [
                    'send_act_id' => SORT_DESC
                ]
            ]
        ]);

        // join with relation `author` that is a relation to the table `users`
        // and set the table alias to be `author`
        $query->joinWith('sendAct');

        // enable sorting for the related column
        //$dataProvider->sort->attributes['printersTypes.types'] = [
            //'asc' => ['printersTypes.types' => SORT_ASC],
           // 'desc' => ['printersTypes.types' => SORT_DESC],
       // ];
        // load the search form data and validate
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // adjust the query by adding the filters

        $query->andFilterWhere(['like', 'send_act_id', $this->getAttribute('send_act_id')])
            ->andFilterWhere(['>=', 'service_send.create_at', Yii::$app->formatter->asTimestamp($this->date_from) ]);

        if($this->date_to != ''){
            $query->andFilterWhere(['<=', 'service_send.create_at', Yii::$app->formatter->asTimestamp($this->date_to) + 86399 ]);
        }
        return $dataProvider;
    }

    //public function attributes()
    //{
        // add related fields to searchable attributes
       // return array_merge(parent::attributes(), ['printersTypes.types']);
   // }

    public function rules()
    {
        // only fields in rules() are searchable
        return [
            [['send_act_id', 'create_at'], 'safe'],
            [['date_from', 'date_to'], 'date', 'format' => 'php:d.m.Y'],

        ];
    }





}