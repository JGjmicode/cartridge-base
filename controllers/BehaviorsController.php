<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;


class BehaviorsController extends Controller{

    public function behaviors(){
        return [
            'access' =>[
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'controllers' => ['site'],
                        'actions' => ['login'],
                        'verbs' => ['GET', 'POST'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => false,
                        'controllers' => ['site'],
                        'actions' => ['login'],
                        'verbs' => ['GET', 'POST'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ]
            ]
        ];
    }

}