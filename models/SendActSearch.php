<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SendAct;

class SendActSearch extends SendAct
{


    public static function tableName()
    {
        return 'send_act';
    }

    public function search($params, $sendActId = false, $cartId = false)
    {

        $query = SendAct::find();
        if($sendActId) {
            $query->where(['act_id' => $sendActId]);
        }
        if($cartId){
            $query->where(['cartridge_id' => $cartId]);
        }



        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 25,
            ],
            'sort' => false,

        ]);

        // join with relation `author` that is a relation to the table `users`
        // and set the table alias to be `author`
        $query->joinWith('cartridges');
        $query->joinWith('serviceSend');

        // enable sorting for the related column
        //$dataProvider->sort->attributes['printersTypes.types'] = [
        //    'asc' => ['printersTypes.types' => SORT_ASC],
        //    'desc' => ['printersTypes.types' => SORT_DESC],
        //];
        // load the search form data and validate
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // adjust the query by adding the filters

        return $dataProvider;
    }

    //public function attributes()
    //{
        // add related fields to searchable attributes
    //    return array_merge(parent::attributes(), ['printersTypes.types']);
   // }

    //public function rules()
    //{
        // only fields in rules() are searchable
    //    return [
    //        [['printersTypes.types', 'model', 'serial', 'inv_number'], 'safe'],
//
     //   ];
  //  }
//




}