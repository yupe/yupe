<?php
/**
 * Install Form Model
 * Класс формы установки:
 *
 * @category YupeForms
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @version  0.0.1
 * @link     http://yupe.ru
 **/

/**
 * Install Form Model
 * Класс формы установки:
 *
 * @category YupeForms
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @version  0.0.1
 * @link     http://yupe.ru
 **/
class InstallForm extends YFormModel
{
    /**
     * Типы баз данных:
     **/
    const DB_MYSQL      = 1;
    const DB_POSTGRESQL = 2;
    const DB_MSSQL      = 3;
    const DB_ORACLE     = 4;
    const DB_SQLITE     = 5;

    /**
     * Параметры для настройки БД:
     **/
    public $host        = 'localhost';
    public $port        = '3306';
    public $socket      = '';
    public $dbName;
    public $dbUser;
    public $dbPassword;
    public $tablePrefix = 'yupe_';
    public $dbType      = self::DB_MYSQL;

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
    public $siteName        = 'Юпи!';
    public $siteDescription = 'Юпи! - самый быстрый способ создать сайт на Yii';
    public $siteKeyWords    = 'Юпи!, yupe, yii, cms, цмс';
    public $siteEmail;
    public $theme           = 'default';
    public $backendTheme    = '';

    public $email;

    /**
     * Правила валидации параметров формы:
     *
     * @return mixed правила валидации параметров формы
     **/
    public function rules()
    {
        return array(
            /**
             * Для настройки БД:
             **/
            array('host, port, dbName, dbUser, tablePrefix, dbType', 'required', 'on' => 'dbSettings'),
            array('dbPassword', 'length', 'min' => 0, 'max' => 32),
            array('port, dbType', 'numerical', 'integerOnly' => true),
            array('dbName, dbUser', 'length', 'min' => 0, 'max' => 256),
            array('socket', 'safe'),

            /**
             * Для начальной настройки сайта:
             **/
            array('siteName, siteDescription, siteKeyWords, siteEmail, theme', 'required', 'on' => 'siteSettings'),
            array('siteName', 'length', 'max' => 30),
            array('siteDescription, siteKeyWords, theme, backendTheme', 'length', 'max' => 180),
            array('siteEmail', 'email'),

            /**
             * Для настройки администратора:
             **/
            array('userName, userPassword, cPassword, userEmail', 'required', 'on' => 'createUser'),
            array('userPassword, cPassword, userName', 'length', 'min' => 3),
            array('cPassword', 'compare', 'compareAttribute' => 'userPassword', 'message' => Yii::t('InstallModule.install', 'Пароли не совпадают!')),
            array('userEmail', 'email'),
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
            /**
             * Для настройки БД:
             **/
            'host'            => Yii::t('InstallModule.install', 'Хост'),
            'port'            => Yii::t('InstallModule.install', 'Порт'),
            'socket'          => Yii::t('InstallModule.install', 'Сокет (если необходимо)'),
            'dbName'          => Yii::t('InstallModule.install', 'Название базы данных'),
            'dbType'          => Yii::t('InstallModule.install', 'Тип сервера базы данных'),
            'dbUser'            => Yii::t('InstallModule.install', 'Пользователь'),
            'dbPassword'        => Yii::t('InstallModule.install', 'Пароль'),
            'tablePrefix'     => Yii::t('InstallModule.install', 'Префикс таблиц'),

            /**
             * Для начальной настройки сайта:
             **/
            'siteName'        => Yii::t('InstallModule.install', 'Название сайта'),
            'siteDescription' => Yii::t('InstallModule.install', 'Описание сайта'),
            'siteKeyWords'    => Yii::t('InstallModule.install', 'Ключевые слова сайта'),
            'siteEmail'           => Yii::t('InstallModule.install', 'Email администратора'),
            'theme'           => Yii::t('InstallModule.install', 'Тема оформления публичной части'),
            'backendTheme'    => Yii::t('InstallModule.install', 'Тема оформления панели управления'),

            /**
             * Для настройки администратора:
             **/
            'userName'        => Yii::t('InstallModule.install', 'Имя пользователя'),
            'userEmail'       => Yii::t('InstallModule.install', 'Email'),
            'userPassword'    => Yii::t('InstallModule.install', 'Пароль'),
            'cPassword'       => Yii::t('InstallModule.install', 'Подтверждение пароля'),
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
            /**
             * Для настройки БД:
             **/
            'host'            => Yii::t('InstallModule.install', 'Домен и ip-адрес используемый для доступа к БД'),
            'port'            => Yii::t('InstallModule.install', 'Порт СУБД сервера'),
            'socket'          => Yii::t('InstallModule.install', 'Путь к mysql'),
            'dbName'          => Yii::t('InstallModule.install', 'Имя БД на сервере СУБД'),
            'dbType'          => Yii::t('InstallModule.install', 'Тип сервера БД (эксперементальная возможность)'),
            'dbUser'          => Yii::t('InstallModule.install', 'Пользователь для доступа к указанной БД'),
            'dbPassword'      => Yii::t('InstallModule.install', 'Пароль для доступа к указанной БД'),
            'tablePrefix'     => Yii::t('InstallModule.install', 'Префикс добавляется в начале имени каждой таблицы, по умолчанию "yupe_"'),
            
            /**
             * Для начальной настройки сайта:
             **/
            'siteName'        => Yii::t('InstallModule.install', 'Используется в заголовке сайта.'),
            'siteDescription' => Yii::t('InstallModule.install', 'Используется в поле description meta-тега.'),
            'siteKeyWords'    => Yii::t('InstallModule.install', 'Используется в поле keywords meta-тега.'),
            'siteEmail'       => Yii::t('InstallModule.install', 'Используется для административной рассылки.'),
            'theme'           => Yii::t('InstallModule.install', 'Определяет внешний вид Вашего сайта.'),
            'backendTheme'    => Yii::t('InstallModule.install', 'Определяет внешний вид панели управления.'),

            /**
             * Для настройки администратора:
             **/
            'userName'        => Yii::t('InstallModule.install', 'Логин администратора сайта.'),
            'userEmail'       => Yii::t('InstallModule.install', 'Email администратора сайта. Используется для авторизации в панели управления.'),
            'userPassword'    => Yii::t('InstallModule.install', 'Пароль администратора сайта.'),
            'cPassword'       => Yii::t('InstallModule.install', 'Подтверждение пароля администратора сайта.'),
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
            self::DB_MYSQL      => 'MySQL',
            self::DB_POSTGRESQL => 'PostgreSQL',
            self::DB_MSSQL      => 'MSSQL',
            self::DB_ORACLE     => 'Oracle',
            self::DB_SQLITE     => 'SQLite',
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
            self::DB_MYSQL      => 'mysql',
            self::DB_POSTGRESQL => 'pgsql',
            self::DB_MSSQL      => 'mssql',
            self::DB_ORACLE     => 'oci',
            self::DB_SQLITE     => 'sqlite',
        );
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
