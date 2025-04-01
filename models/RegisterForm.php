<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\NewUsers;

class RegisterForm extends Model
{
    public $login;
    public $email;
    public $password;
    public $password_repeat;
    public $agreement;

    public function rules()
    {
        return [
            [['login', 'email', 'password', 'password_repeat'], 'required', 'message' => 'Это поле обязательно для заполнения.'],
            ['email', 'email', 'message' => 'Введите корректный email.'],
            ['email', 'unique', 'targetClass' => NewUsers::class, 'message' => 'Этот email уже зарегистрирован.'],
            ['password', 'string', 'min' => 6, 'tooShort' => 'Пароль должен содержать минимум 6 символов.'],
            ['password', 'match', 'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
                'message' => 'Пароль должен содержать хотя бы одну заглавную букву, одну строчную, одну цифру и один спецсимвол (@$!%*?&).'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают.'],
            ['agreement', 'boolean'],
            ['agreement', 'compare', 'compareValue' => true, 'message' => 'Вы должны согласиться с условиями.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'login' => 'Логин/Никнейм',
            'email' => 'email',
            'password' => 'Пароль',
            'image' => 'Изображение',
            'agreement' => '',
        ];
    }

    public function register()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = new NewUsers();
        $user->login = $this->login;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        if(Yii::$app->db->createCommand("INSERT INTO new_users (login, email, password, auth_key) VALUES (:login, :email, :password, :auth_key)", [
            ':login' => $user->login,
            ':email' => $user->email,
            ':password' => $user->password,
            ':auth_key' => $user->auth_key,
        ])->execute()){
            return true;
        }else{
            return false;
        }
        
    }
}