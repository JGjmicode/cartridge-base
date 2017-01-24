<?php
/**
 * Created by PhpStorm.
 * User: Nuwak
 * Date: 02.01.2016
 * Time: 6:05
 */
namespace app\models;
use yii\base\Model;
use Yii;
use app\models\User;
class RegForm extends Model {

    public $username;
    public $password;
    public $name;
    public function rules(){
        return [
            [['username', 'password'],'filter', 'filter' => 'trim'],
            [['username', 'password', 'name'],'required'],
            ['username','string','min' => 2, 'max' => 255],
            ['password', 'string', 'min' => 6, 'max' => 255],
            ['username', 'unique', 'targetClass' => User::ClassName(), 'message' => 'Это имя уже занято.'],
//            ['username', 'string', 'min' => 5, 'on' => 'test']
            ]
            ;
    }
    public function reg()
    {
        $user = new User();
        $user->username = $this->username;
        $user->status = 1;
        $user->name = $this->name;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        if($user->save()):
            return $user;
        else:
            return null;
        endif;
    }
    public function attributeLabels(){
        return [
            'username' => 'Имя пользователя',
            'password' => 'Пароль',
            'name' => 'Ф.И.О.',
        ];
    }
}