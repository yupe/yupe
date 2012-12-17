<?php
class CreateUserForm extends YFormModel
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
            'userName'  => Yii::t('install', 'Имя пользователя'),
            'email'     => Yii::t('install', 'Email'),
            'password'  => Yii::t('install', 'Пароль'),
            'cPassword' => Yii::t('install', 'Подтверждение пароля'),
        );
    }

    public function attributeDescriptions()
    {
        return array(
            'userName'  => Yii::t('install', 'Логин администратора сайта.'),
            'email'     => Yii::t('install', 'Email администратора сайта. Используется для авторизации в панели управления.'),
            'password'  => Yii::t('install', 'Пароль администратора сайта.'),
            'cPassword' => Yii::t('install', 'Подтверждение пароля администратора сайта.'),
        );
    }
}