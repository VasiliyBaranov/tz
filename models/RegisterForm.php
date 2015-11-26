<?php
namespace app\models;

use yii\base\Model;
use Yii;

class RegisterForm extends Model
{
    public $username;
    public $email;
    public $password;
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'string'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Это имя пользователя уже занято.'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Этот email уже занят.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'app\models\User', 'message' => 'Этот email уже занят.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }
    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя (Никнэйм)',
            'password' => 'Пароль',
            'email' => 'Ваш e-mail',
        ];
    }

    public function register()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        }
        return null;
    }

}