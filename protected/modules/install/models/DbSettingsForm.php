<?php
class DbSettingsForm extends YFormModel
{
    public $host   = 'localhost';
    public $port   = '3306';
    public $socket = '';
    public $dbName;
    public $user;
    public $password;
    //@TODO в форму "Настройки соединения с БД" вынести поле "Префикс таблиц"
    public $tablePrefix = 'yupe_';

    public function rules()
    {
        return array(
            array('host, port, dbName, user', 'required'),
            array('password', 'length', 'min' => 0, 'max' => 32),
            array('port', 'numerical', 'integerOnly' => true),
            array('socket', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'host'     => Yii::t('install', 'Хост'),
            'port'     => Yii::t('install', 'Порт'),
            'socket'   => Yii::t('install', 'Сокет'),
            'dbName'   => Yii::t('install', 'Название базы данных'),
            'user'     => Yii::t('install', 'Пользователь'),
            'password' => Yii::t('install', 'Пароль'),
        );
    }

    public function attributeDescriptions()
    {
        return array(
            'host'     => Yii::t('install', 'Домен и ip-адрес используемый для доступа к БД.'),
            'port'     => Yii::t('install', 'Порт mysql-сервер.'),
            'socket'   => Yii::t('install', 'Путь к mysql. Заполнение не обязательно.'),
            'dbName'   => Yii::t('install', 'Имя БД на mysql-сервере.'),
            'user'     => Yii::t('install', 'Пользователь для доступа к указанной БД.'),
            'password' => Yii::t('install', 'Пароль для доступа к указанной БД.'),
        );
    }
}