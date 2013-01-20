<?php
/**
 * DbSettings Form Model
 * Класс формы для настройки БД:
 *
 * @category YupeForms
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @version  0.0.1
 * @link     http://yupe.ru
 **/

/**
 * DbSettings Form Model
 * Класс формы для настройки БД:
 *
 * @category YupeForms
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @version  0.0.1
 * @link     http://yupe.ru
 **/
class DbSettingsForm extends YFormModel
{
    /**
     * Типы баз данных:
     **/
    const DB_MYSQL = 1;
    const DB_POSTGRESQL = 2;
    const DB_MSSQL = 3;
    const DB_ORACLE = 4;
    const DB_SQLITE = 5;

    public $host   = 'localhost';
    public $port   = '3306';
    public $socket = '';
    public $dbName;
    public $user;
    public $password;
    public $tablePrefix = 'yupe_';
    public $dbType = self::DB_MYSQL;

    /**
     * Правила валидации параметров формы:
     *
     * @return mixed правила валидации параметров формы
     **/
    public function rules()
    {
        return array(
            array('host, port, dbName, user, tablePrefix, dbType', 'required'),
            array('password', 'length', 'min' => 0, 'max' => 32),
            array('port, dbType', 'numerical', 'integerOnly' => true),
            array('socket', 'safe'),
        );
    }

    /**
     * Отображаемые названия параметров формы:
     *
     * @return mixed отображаемые названия параметров формы
     **/
    public function attributeLabels()
    {
        return array(
            'host'        => Yii::t('InstallModule.install', 'Хост'),
            'port'        => Yii::t('InstallModule.install', 'Порт'),
            'socket'      => Yii::t('InstallModule.install', 'Сокет (если необходимо)'),
            'dbName'      => Yii::t('InstallModule.install', 'Название базы данных'),
            'dbType'      => Yii::t('InstallModule.install', 'Тип сервера базы данных'),
            'user'        => Yii::t('InstallModule.install', 'Пользователь'),
            'password'    => Yii::t('InstallModule.install', 'Пароль'),
            'tablePrefix' => Yii::t('InstallModule.install', 'Префикс таблиц'),
        );
    }

    /**
     * Отображаемые описания параметров формы:
     *
     * @return mixed отображаемые описания параметров формы
     **/
    public function attributeDescriptions()
    {
        return array(
            'host'        => Yii::t('InstallModule.install', 'Домен и ip-адрес используемый для доступа к БД'),
            'port'        => Yii::t('InstallModule.install', 'Порт СУБД сервера'),
            'socket'      => Yii::t('InstallModule.install', 'Путь к mysql'),
            'dbName'      => Yii::t('InstallModule.install', 'Имя БД на сервере СУБД'),
            'dbType'      => Yii::t('InstallModule.install', 'Тип сервера БД (эксперементальная возможность)'),
            'user'        => Yii::t('InstallModule.install', 'Пользователь для доступа к указанной БД'),
            'password'    => Yii::t('InstallModule.install', 'Пароль для доступа к указанной БД'),
            'tablePrefix' => Yii::t('InstallModule.install', 'Префикс добавляется в начале имени каждой таблицы, по умолчанию "yupe_"'),
        );
    }

    /**
     * Названия для типов БД:
     *
     * @return mixed названия для типов БД:
     **/
    public function getDbTypeNames()
    {
        return array(
            self::DB_MYSQL => 'MySQL',
            self::DB_POSTGRESQL => 'PostgreSQL',
            self::DB_MSSQL => 'MSSQL',
            self::DB_ORACLE => 'Oracle',
            self::DB_SQLITE => 'SQLite',
        );
    }

    /**
     * Названия бд для строк подключения:
     *
     * @return mixed названия для типов БД:
     **/
    public function getDbTypes()
    {
        /**
         * @todo sqlite и oracle имееют специфические настройки подключения
         *       стоит придумать как это лучше реализовать
         **/
        return array(
            self::DB_MYSQL => 'mysql',
            self::DB_POSTGRESQL => 'pgsql',
            self::DB_MSSQL => 'mssql',
            self::DB_ORACLE => 'oci',
            self::DB_SQLITE => 'sqlite',
        );
    }
}
