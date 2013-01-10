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
            array('password', 'compare', 'compareAttribute' => 'cPassword', 'message' => Yii::t('InstallModule.install', 'Пароли не совпадают!')),
            array('email', 'email'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'userName'  => Yii::t('InstallModule.install', 'Имя пользователя'),
            'email'     => Yii::t('InstallModule.install', 'Email'),
            'password'  => Yii::t('InstallModule.install', 'Пароль'),
            'cPassword' => Yii::t('InstallModule.install', 'Подтверждение пароля'),
        );
    }

    public function attributeDescriptions()
    {
        return array(
            'userName'  => Yii::t('InstallModule.install', 'Логин администратора сайта.'),
            'email'     => Yii::t('InstallModule.install', 'Email администратора сайта. Используется для авторизации в панели управления.'),
            'password'  => Yii::t('InstallModule.install', 'Пароль администратора сайта.'),
            'cPassword' => Yii::t('InstallModule.install', 'Подтверждение пароля администратора сайта.'),
        );
    }
}