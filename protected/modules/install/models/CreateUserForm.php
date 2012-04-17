<?php
class CreateUserForm extends CFormModel
{
    public $userName;

    public $password;

    public $cPassword;

    public $email;

    public function rules()
    {
        return array(
            array('userName, password, cPassword, email', 'required'),
            array('password, cPassword', 'length', 'min' => 3),
            array('password', 'compare', 'compareAttribute' => 'cPassword', 'message' => Yii::t('install', 'Пароли не совпадают!')),
            array('email', 'email'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'userName' => Yii::t('install', 'Имя пользователя'),
            'email' => Yii::t('install', 'Email'),
            'password' => Yii::t('install', 'Пароль'),
            'cPassword' => Yii::t('install', 'Подтверждение пароля'),
        );
    }
}