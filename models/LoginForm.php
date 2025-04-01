<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\NewUsers;
use PhpParser\Node\Expr\New_;

class LoginForm extends Model
{
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
        ];
    }

    public function login()
    {
        $user = NewUsers::findOne(['email' => $this->email]);

        if ($user && Yii::$app->security->validatePassword($this->password, $user->password)) {
            return Yii::$app->user->login($user);
        }

        return false;
    }
}