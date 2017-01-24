<?php
namespace app\models;
use app\models\GetAct;
use yii\data\ActiveDataProvider;

class GetActSearch extends GetAct{

    public static function tableName(){
        return 'get-act';
    }

    public function search($params, $act_id){
        $query = GetAct::find()->where(['act_id' => $act_id])->orderBy('id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 25
            ],
            'sort' => false,
        ]);

        $query->joinWith('cartridges');
        $query->joinWith('serviceSend');

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // adjust the query by adding the filters

        return $dataProvider;

    }

}