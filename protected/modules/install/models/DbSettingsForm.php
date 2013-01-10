<?php
class DbSettingsForm extends YFormModel
{
    public $host   = 'localhost';
    public $port   = '3306';
    public $socket = '';
    public $dbName;
    public $user;
    public $password;
    public $tablePrefix = 'yupe';

    public function rules()
    {
        return array(
            array('host, port, dbName, user, tablePrefix', 'required'),
            array('password', 'length', 'min' => 0, 'max' => 32),
            array('port', 'numerical', 'integerOnly' => true),
            array('socket', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'host'        => Yii::t('InstallModule.install', 'Хост'),
            'port'        => Yii::t('InstallModule.install', 'Порт'),
            'socket'      => Yii::t('InstallModule.install', 'Сокет (если необходимо)'),
            'dbName'      => Yii::t('InstallModule.install', 'Название базы данных'),
            'user'        => Yii::t('InstallModule.install', 'Пользователь'),
            'password'    => Yii::t('InstallModule.install', 'Пароль'),
            'tablePrefix' => Yii::t('InstallModule.install', 'Префикс таблиц'),
        );
    }

    public function attributeDescriptions()
    {
        return array(
            'host'        => Yii::t('InstallModule.install', 'Домен и ip-адрес используемый для доступа к БД'),
            'port'        => Yii::t('InstallModule.install', 'Порт mysql-сервер'),
            'socket'      => Yii::t('InstallModule.install', 'Путь к mysql'),
            'dbName'      => Yii::t('InstallModule.install', 'Имя БД на mysql-сервере'),
            'user'        => Yii::t('InstallModule.install', 'Пользователь для доступа к указанной БД'),
            'password'    => Yii::t('InstallModule.install', 'Пароль для доступа к указанной БД'),
            'tablePrefix' => Yii::t('InstallModule.install', 'Префикс добавляется в начале имени каждой таблицы, по умолчанию "yupe_"'),
        );
    }
}