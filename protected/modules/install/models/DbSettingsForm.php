<?php
class DbSettingsForm extends YFormModel
{
    const DB_MYSQL = 1;
    const DB_POSTGRES = 2;

    public $host   = 'localhost';
    public $port   = '3306';
    public $socket = '';
    public $dbName;
    public $user;
    public $password;
    public $tablePrefix = 'yupe_';
    public $dbType = 0;

    /**
     * Возвращаем типы БД:
     *
     * @return mixed
     **/
    public function getDbTypes()
    {
        return array(
            self::DB_MYSQL    => 'mysql',
            self::DB_POSTGRES => 'pgsql',
        );
    }

    public function rules()
    {
        return array(
            array('host, port, dbName, user, tablePrefix, dbType', 'required'),
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
            'dbType'      => Yii::t('InstallModule.install', 'Тип базы данных'),
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
            'dbName'      => Yii::t('InstallModule.install', 'Тип используемого сервера БД'),
            'user'        => Yii::t('InstallModule.install', 'Пользователь для доступа к указанной БД'),
            'password'    => Yii::t('InstallModule.install', 'Пароль для доступа к указанной БД'),
            'tablePrefix' => Yii::t('InstallModule.install', 'Префикс добавляется в начале имени каждой таблицы, по умолчанию "yupe_"'),
        );
    }
}
