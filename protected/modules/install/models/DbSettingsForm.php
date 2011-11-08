<?php
class DbSettingsForm extends CFormModel
{
    public $host = 'localhost';

    public $port = '3306';

    public $dbName;

    public $user;

    public $password;

    //@TODO в форму "Настройки соединения с БД" вынести поле "Префикс таблиц"

    public function rules()
    {
        return array(
            array('host, port, dbName, user', 'required'),
            array('password', 'length', 'min' => 0, 'max' => 32),
            array('port', 'numerical', 'integerOnly' => true),
        );
    }

    public function attributeLabels()
    {
        return array(
            'host' => Yii::t('install', 'Host'),
            'port' => Yii::t('install', 'Порт'),
            'dbName' => Yii::t('install', 'Название базы данных'),
            'user' => Yii::t('install', 'Пользователь'),
            'password' => Yii::t('install', 'Пароль')
        );
    }
}