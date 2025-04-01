<?php
namespace app\models;

use yii\base\Model;
use Yii;

class ChangePasswordForm extends Model
{
    /*public $oldPassword;
    public $newPassword;
    public $confirmPassword;

    public function rules()
    {
        return [
            [['oldPassword', 'newPassword', 'confirmPassword'], 'required'],
            ['oldPassword', 'validateOldPassword'],
            ['newPassword', 'string', 'min' => 6],
            ['confirmPassword', 'compare', 'compareAttribute' => 'newPassword', 'message' => 'Пароли не совпадают'],
        ];
    }
    
    public function validateOldPassword($attribute, $params)
    {
        $user = Yii::$app->user->identity;
        if (!$user || !Yii::$app->security->validatePassword($this->oldPassword, $user->newPassword)) {
            $this->addError($attribute, 'Неверный текущий пароль.');
        }
    }
    /
    public function changePassword()
    {
        $user = Yii::$app->user->identity;
        if ($this->validate()) {
            $user->newPassword = Yii::$app->security->generatePasswordHash($this->newPassword);
            return $user->save();
        }
        return false;
    }
*/}