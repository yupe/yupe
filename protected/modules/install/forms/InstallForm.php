<?php

/**
 * Install Form Model
 * Класс формы установки:
 *
 * @category YupeForms
 * @package  yupe.modules.install.forms
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @version  0.0.1
 * @link     http://yupe.ru
 **/
class InstallForm extends yupe\models\YFormModel
{
    /**
     * Типы баз данных:
     **/
    const DB_MYSQL = 1;
    const DB_POSTGRESQL = 2;
    const DB_MSSQL = 3;
    const DB_ORACLE = 4;

    /**
     * Параметры для настройки БД:
     **/
    public $host = '127.0.0.1';
    public $port = '3306';
    public $socket = '';
    public $dbName;
    public $createDb;
    public $dbUser;
    public $dbPassword;
    public $tablePrefix = 'yupe_';
    public $dbType = self::DB_MYSQL;

    /**
     * Для создания пользователя:
     **/
    public $userName;
    public $userPassword;
    public $cPassword;
    public $userEmail;

    /**
     * Для начальной настройки сайта:
     **/
    public $siteName = 'Юпи!';
    public $siteDescription = 'Юпи! - самый быстрый способ создать сайт на Yii';
    public $siteKeyWords = 'Юпи!, yupe, yii, cms, цмс';
    public $siteEmail;
    public $theme = 'default';
    public $backendTheme = '';

    public $email;

    public function init()
    {
        $this->siteName = Yii::t('InstallModule.install', 'Yupe!');
        $this->siteKeyWords = Yii::t('InstallModule.install', 'Yupe!, yupe, cms, yii');
        $this->siteDescription = Yii::t(
            'InstallModule.install',
            'Yupe! - the fastest way to create a site build on top of Yiiframework!'
        );
        parent::init();
    }

    /**
     * Правила валидации параметров формы:
     *
     * @return mixed правила валидации параметров формы
     **/
    public function rules()
    {
        return [
            /**
             * Для настройки БД:
             **/
            ['host, port, dbName, dbUser, dbType', 'required', 'on' => 'dbSettings'],
            ['dbPassword', 'length', 'min' => 0, 'max' => 32],
            ['port, dbType', 'numerical', 'integerOnly' => true],
            ['dbName, dbUser', 'length', 'min' => 0, 'max' => 255],
            ['socket, createDb, tablePrefix', 'safe'],
            /**
             * Для начальной настройки сайта:
             **/
            ['siteName, siteDescription, siteKeyWords, siteEmail, theme', 'required', 'on' => 'siteSettings'],
            ['siteName', 'length', 'max' => 255],
            ['siteDescription, siteKeyWords, theme, backendTheme', 'length', 'max' => 180],
            ['siteEmail', 'email'],
            /**
             * Для настройки администратора:
             **/
            ['userName, userPassword, cPassword, userEmail', 'required', 'on' => 'createUser'],
            ['userPassword, cPassword', 'length', 'min' => 8],
            ['userName', 'length', 'min' => 4],
            [
                'cPassword',
                'compare',
                'compareAttribute' => 'userPassword',
                'message'          => Yii::t('InstallModule.install', 'Passwords are not consistent')
            ],
            ['userEmail', 'email'],
        ];
    }

    /**
     * Отображаемые названия параметров формы:
     *
     * @return mixed отображаемые названия параметров формы
     **/
    public function attributeLabels()
    {
        return [
            /**
             * Для настройки БД:
             **/
            'host'            => Yii::t('InstallModule.install', 'Host'),
            'port'            => Yii::t('InstallModule.install', 'Port'),
            'socket'          => Yii::t('InstallModule.install', 'Unix socket (if it need)'),
            'dbName'          => Yii::t('InstallModule.install', 'DB name'),
            'createDb'        => Yii::t('InstallModule.install', 'Create DB'),
            'dbType'          => Yii::t('InstallModule.install', 'DBMS type'),
            'dbUser'          => Yii::t('InstallModule.install', 'User'),
            'dbPassword'      => Yii::t('InstallModule.install', 'Password'),
            'tablePrefix'     => Yii::t('InstallModule.install', 'Tables prefix'),
            /**
             * Для начальной настройки сайта:
             **/
            'siteName'        => Yii::t('InstallModule.install', 'Site title'),
            'siteDescription' => Yii::t('InstallModule.install', 'Site description'),
            'siteKeyWords'    => Yii::t('InstallModule.install', 'Site keywords'),
            'siteEmail'       => Yii::t('InstallModule.install', 'Administrator e-mail'),
            'theme'           => Yii::t('InstallModule.install', 'Default frontend theme'),
            'backendTheme'    => Yii::t('InstallModule.install', 'Default backend (Admin CP) theme'),
            /**
             * Для настройки администратора:
             **/
            'userName'        => Yii::t('InstallModule.install', 'User name'),
            'userEmail'       => Yii::t('InstallModule.install', 'Email'),
            'userPassword'    => Yii::t('InstallModule.install', 'Password'),
            'cPassword'       => Yii::t('InstallModule.install', 'Password confirm'),
        ];
    }

    /**
     * Отображаемые описания параметров формы:
     *
     * @return mixed отображаемые описания параметров формы
     **/
    public function attributeDescriptions()
    {
        return [
            /**
             * Для настройки БД:
             **/
            'host'            => Yii::t('InstallModule.install', 'DNS and IP for DB access'),
            'port'            => Yii::t('InstallModule.install', 'DBMS server port'),
            'socket'          => Yii::t('InstallModule.install', 'Path to mysql'),
            'dbName'          => Yii::t('InstallModule.install', 'DB name on DBMS server'),
            'createDb'        => Yii::t('InstallModule.install', 'Create DB on DBMS server'),
            'dbType'          => Yii::t('InstallModule.install', 'DBMS type (Experimental)'),
            'dbUser'          => Yii::t('InstallModule.install', 'User for access to selected DB'),
            'dbPassword'      => Yii::t('InstallModule.install', 'DB access password'),
            'tablePrefix'     => Yii::t('InstallModule.install', 'Table prefix, "yupe_" by defaults'),
            /**
             * Для начальной настройки сайта:
             **/
            'siteName'        => Yii::t('InstallModule.install', 'Using in site title'),
            'siteDescription' => Yii::t('InstallModule.install', 'Using in description meta-tag'),
            'siteKeyWords'    => Yii::t('InstallModule.install', 'Using in keywords meta-tag'),
            'siteEmail'       => Yii::t('InstallModule.install', 'Using for administration delivery'),
            'theme'           => Yii::t('InstallModule.install', 'Describe appearance of your Site'),
            'backendTheme'    => Yii::t('InstallModule.install', 'Describe appearance of your Control Panel'),
            /**
             * Для настройки администратора:
             **/
            'userName'        => Yii::t('InstallModule.install', 'Admin login'),
            'userEmail'       => Yii::t(
                    'InstallModule.install',
                    'Site administrator e-mail. Uses for admin cp authorization.'
                ),
            'userPassword'    => Yii::t('InstallModule.install', 'Admin password'),
            'cPassword'       => Yii::t('InstallModule.install', 'Admin password confirm'),
        ];
    }

    /**
     * Названия для типов БД:
     *
     * @return mixed названия для типов БД:
     **/
    public function getDbTypeNames()
    {
        /** Определяем доступные базы данных:
         *
         * Варианты СУБД
         *
         * self::DB_MYSQL => 'MySQL',
         *
         */

        $dbTypes = [];
        /**
         * Проверяем доступные СУБД:
         */

        if (extension_loaded('pdo_mysql')) {
            $dbTypes[self::DB_MYSQL] = 'MySQL';
        }

        return $dbTypes;
    }

    /**
     * Названия бд для строк подключения:
     *
     * @return mixed названия для типов БД:
     **/
    public function getDbTypes()
    {
        return [
            self::DB_MYSQL      => 'mysql',
            self::DB_POSTGRESQL => 'pgsql',
        ];
    }

    /**
     * Получение аттрибута почты:
     *
     * @return string аттрибут почты:
     **/
    public function getEmailName()
    {
        return User::model()->admin()->find()->getAttribute('email');
    }

}
