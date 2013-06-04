<?php
/**
 * Default Install Controller
 * Класс контроллера установки движка Юпи:
 *
 * @category YupeControllers
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @version  0.0.1
 * @link     http://yupe.ru
 **/

/**
 * Default Install Controller
 * Класс контроллера установки движка Юпи:
 *
 * @category YupeControllers
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @version  0.0.1
 * @link     http://yupe.ru
 **/
class DefaultController extends YBackController
{
    /**
     * Переменная названия текущего шага:
     **/
    public $stepName;

    /**
     * Параметры из сессии:
     **/
    public $session = array();

    /**
     * Функция фильтров:
     *
     * @return mixed filters
     **/
    public function filters()
    {
        return array();
    }

    /**
     * Функция инициализации:
     *
     * @return nothing
     **/
    public function init()
    {
        parent::init();

        if (!isset(Yii::app()->session['InstallForm'])) {
            Yii::app()->session['InstallForm'] = array();
        }
        $this->session['InstallForm'] = Yii::app()->session['InstallForm'];

        $this->setPageTitle(Yii::t('InstallModule.install', 'Установка Юпи!'));

        $this->layout = 'application.modules.install.views.layouts.column2';
    }

    /**
     * Установка данных в сессию:
     *
     * @return nothing
     **/
    private function _setSession()
    {
        Yii::app()->session['InstallForm'] = $this->session['InstallForm'];
    }

    /**
     * Установка выполнения шага:
     *
     * @param bool|string $actionId - требуемый экшен:
     *
     * @return nothing
     */
    private function _markFinished($actionId = false)
    {
        if (!$actionId) {
            return;
        }

        $this->session['InstallForm'] = array_merge(
            $this->session['InstallForm'],
            array(
                $actionId . 'Finished' => true,
            )
        );

        $this->_setSession();
    }

    /**
     * Функция выполняющаяся до вызова экшена
     * (если $this->yupe->cache истина - очищаем кэш)
     *
     * @param $action - вызванный нами экшен
     *
     * @return bool вызов родительского метода beforeAction
     */
    protected function beforeAction($action)
    {
        if ($this->yupe->cache) {
            Yii::app()->cache->flush();
        }

        /**
         * Если шаг не выполнен - возвращаем на предыдущий:
         **/
        $this->_markFinished('index');
        $isStepFinished = Yii::app()->controller->module->isStepFinished(
                Yii::app()->controller->module->getPrevStep($action->id)
            ) || Yii::app()->controller->module->isStepFinished(
                $action->id
            );
        if (!$isStepFinished && !in_array($action->id, array('index', 'moduleinstall'))) {
            $this->redirect(
                $this->createUrl(Yii::app()->controller->module->getPrevStep())
            );
        }
        $this->stepName = Yii::app()->controller->module->getInstallSteps($action->id);
        return true;
    }

    /**
     * Начальный экшен:
     *
     * @return nothing
     **/
    public function actionIndex()
    {
        $this->_markFinished('index');
        $this->session['InstallForm'] = array();
        $this->_setSession();
        $this->render('_view');
    }

    /**
     * Экшен проверки окружения:
     *
     * @return nothing
     **/
    public function actionEnvironment()
    {
        $webRoot = Yii::getPathOfAlias('webroot');
        $dp = DIRECTORY_SEPARATOR;

        $requirements = array(
            array(
                Yii::t('InstallModule.install', 'Папка assets'),
                $this->_checkWritable($webRoot . '/assets/'),
                Yii::t(
                    'InstallModule.install',
                    'Необходимо установить права записи на папку {folder}assets',
                    array(
                        '{folder}' => $webRoot . $dp,
                    )
                ),
            ),
            array(
                Yii::t('InstallModule.install', 'Папка runtime'),
                $this->_checkWritable($webRoot . '/protected/runtime/'),
                Yii::t(
                    'InstallModule.install',
                    'Необходимо установить права записи на папку {folder}',
                    array(
                        '{folder}' => $webRoot . $dp . 'protected' . $dp . 'runtime',
                    )
                ),
            ),
            array(
                Yii::t('InstallModule.install', 'Папка uploads'),
                $this->_checkWritable($webRoot . '/uploads/'),
                Yii::t(
                    'InstallModule.install',
                    'Необходимо установить права записи на папку {folder}',
                    array(
                        '{folder}' => $webRoot . $dp . 'uploads',
                    )
                ),
            ),
            array(
                Yii::t('InstallModule.install', 'Папка modules'),
                $this->_checkWritable($webRoot . '/protected/config/modules/'),
                Yii::t(
                    'InstallModule.install',
                    'Необходимо установить права записи на папку {folder}',
                    array(
                        '{folder}' => $webRoot . $dp . 'protected' . $dp . 'config' . $dp . 'modules',
                    )
                ),
            ),
            array(
                Yii::t('InstallModule.install', 'Папка modulesBack'),
                $this->_checkWritable($webRoot . '/protected/config/modulesBack/'),
                Yii::t(
                    'InstallModule.install',
                    'Необходимо установить права записи на папку {folder}',
                    array(
                        '{folder}' => $webRoot . $dp . 'protected' . $dp . 'config' . $dp . 'modulesBack',
                    )
                ),
            ),
            array(
                Yii::t('InstallModule.install', 'Файл db.php'),
                $this->_checkConfigFileWritable(
                    $webRoot . '/protected/config/db.back.php',
                    $webRoot . '/protected/config/db.php'
                ),
                Yii::t(
                    'InstallModule.install',
                    'Необходимо скопировать {file} и дать ему права на запись',
                    array(
                        '{file}' => $webRoot . $dp . 'protected' . $dp . 'config' . $dp . 'db.back.php в ' . $webRoot . $dp . 'protected' . $dp . 'config' . $dp . 'db.php',
                    )
                ),
            ),
        );

        $result = true;
        $commentOk = Yii::t('InstallModule.install', 'Все хорошо!');

        foreach ($requirements as $i => $requirement) {
            (!$requirement[1])
                ? $result = false
                : $requirements[$i][2] = $commentOk;
        }

        if ($result) {
            $result = $this->_checkYupeActivate();
        }


        if ($result) {
            $this->_markFinished(Yii::app()->controller->action->id);
        }


        $requirements = array_merge(
            $requirements,
            array(
                array(
                    Yii::t('InstallModule.install', 'Активация ядра Юпи!'),
                    $result,
                    (!$result)
                        ? Yii::t(
                        'InstallModule.install',
                        'При запуске ядра произошли ошибки, пожалуйста, проверьте права доступа на все необходимые файлы и каталоги (см. ошибки выше)'
                    )
                        : $commentOk,
                )
            )
        );

        $this->render(
            '_view',
            array(
                'data' => array(
                    'requirements' => $requirements,
                    'result' => $result,
                )
            )
        );
    }

    /**
     * Функция проверки возможности записи в каталог:
     * (приватные функции начинаются с подчёркивания)
     *
     * @param string $path - путь каталога
     *
     * @return bool возможность записи в каталог
     **/
    private function _checkWritable($path)
    {
        return is_writable($path) || @chmod($path, 0777) && is_writable($path);
    }

    /**
     * Функция проверки возможности записи и копирования в конфигурационный файл:
     * (приватные функции начинаются с подчёркивания)
     *
     * @param string $pathOld - старый путь файла
     * @param string $pathNew - новый путь файла
     *
     * @return bool проверка возможности скопировать и писать в конфигурационный файл
     **/
    private function _checkConfigFileWritable($pathOld, $pathNew)
    {
        return is_writable($pathNew) || @copy($pathOld, $pathNew) && is_writable($pathNew);
    }

    /**
     * Проверка активации модуля Юпи!
     * (приватные функции начинаются с подчёркивания)
     *
     * @return bool
     **/
    private function _checkYupeActivate()
    {
        return $this->yupe->getActivate(true, true);
    }

    /**
     * Экшен "Проверки системных требований"
     *
     * @return nothing
     **/
    public function actionRequirements()
    {
        $requirements = array(
            array(
                Yii::t('InstallModule.install', 'Версия РНР'),
                true,
                version_compare(PHP_VERSION, "5.3.0", ">="),
                '<a href="http://www.yiiframework.com">Yii Framework</a>',
                Yii::t('InstallModule.install', 'Необходима версия PHP 5.3 и выше.'),
            ),
            array(
                Yii::t('InstallModule.install', 'Переменная $_SERVER'),
                true,
                '' === $message = $this->_checkServerVar(),
                '<a href="http://www.yiiframework.com">Yii Framework</a>',
                $message,
            ),
            array(
                Yii::t('InstallModule.install', 'Расширение Reflection'),
                true,
                class_exists('Reflection', false),
                '<a href="http://www.yiiframework.com">Yii Framework</a>',
                '',
            ),
            array(
                Yii::t('InstallModule.install', 'Расширение PCRE'),
                true,
                extension_loaded("pcre"),
                '<a href="http://www.yiiframework.com">Yii Framework</a>',
                '',
            ),
            array(
                Yii::t('InstallModule.install', 'Расширение SPL'),
                true,
                extension_loaded("SPL"),
                '<a href="http://www.yiiframework.com">Yii Framework</a>',
                '',
            ),
            array(
                Yii::t('InstallModule.install', 'Расширение DOM'),
                false,
                class_exists("DOMDocument", false),
                '<a href="http://www.yiiframework.com/doc/api/CHtmlPurifier">CHtmlPurifier</a>,
                 <a href="http://www.yiiframework.com/doc/api/CWsdlGenerator">CWsdlGenerator</a>',
                '',
            ),
            array(
                Yii::t('InstallModule.install', 'Расширение PDO'),
                true,
                extension_loaded('pdo'),
                Yii::t(
                    'InstallModule.install',
                    'Все <a href="http://www.yiiframework.com/doc/api/#system.db">DB-классы</a>'
                ),
                '',
            ),
            array(
                Yii::t('InstallModule.install', 'Расширение PDO SQLite'),
                false,
                extension_loaded('pdo_sqlite'),
                Yii::t(
                    'InstallModule.install',
                    'Все <a href="http://www.yiiframework.com/doc/api/#system.db">DB-классы</a>'
                ),
                Yii::t('InstallModule.install', 'Требуется для работы с БД SQLite.'),
            ),
            array(
                Yii::t('InstallModule.install', 'Расширение PDO MySQL'),
                false,
                extension_loaded('pdo_mysql'),
                Yii::t(
                    'InstallModule.install',
                    'Все <a href="http://www.yiiframework.com/doc/api/#system.db">DB-классы</a>'
                ),
                Yii::t('InstallModule.install', 'Требуется для работы с БД MySQL.'),
            ),
            array(
                Yii::t('InstallModule.install', 'Расширение PDO PostgreSQL'),
                false,
                extension_loaded('pdo_pgsql'),
                Yii::t(
                    'InstallModule.install',
                    'Все <a href="http://www.yiiframework.com/doc/api/#system.db">DB-классы</a>'
                ),
                Yii::t('InstallModule.install', 'Требуется для работы с БД PostgreSQL.')
            ),
            array(
                Yii::t('InstallModule.install', 'Расширение PDO Oracle'),
                false,
                extension_loaded('pdo_oci'),
                Yii::t(
                    'InstallModule.install',
                    'Все <a href="http://www.yiiframework.com/doc/api/#system.db">DB-классы</a>'
                ),
                Yii::t('InstallModule.install', 'Требуется для работы с БД Oracle.')
            ),
            array(
                Yii::t('InstallModule.install', 'Расширение PDO MSSQL (pdo_mssql)'),
                false,
                extension_loaded('pdo_mssql'),
                Yii::t(
                    'InstallModule.install',
                    'Все <a href="http://www.yiiframework.com/doc/api/#system.db">DB-классы</a>'
                ),
                Yii::t('InstallModule.install', 'Требуется для работы с БД MSSQL при использовании из MS Windows.')
            ),
            array(
                Yii::t('InstallModule.install', 'Расширение PDO MSSQL (pdo_dblib)'),
                false,
                extension_loaded('pdo_dblib'),
                Yii::t(
                    'InstallModule.install',
                    'Все <a href="http://www.yiiframework.com/doc/api/#system.db">DB-классы</a>'
                ),
                Yii::t(
                    'InstallModule.install',
                    'Требуется для работы с БД MSSQL при использовании из GNU/Linux или UNIX.'
                )
            ),
            array(
                Yii::t(
                    'InstallModule.install',
                    'Расширение PDO MSSQL (<a href="http://sqlsrvphp.codeplex.com/">pdo_sqlsrv</a>)'
                ),
                false,
                extension_loaded('pdo_sqlsrv'),
                Yii::t(
                    'InstallModule.install',
                    'Все <a href="http://www.yiiframework.com/doc/api/#system.db">DB-классы</a>'
                ),
                Yii::t(
                    'InstallModule.install',
                    'Требуется для работы с БД MSSQL при использовании драйвера от Microsoft'
                )
            ),
            array(
                Yii::t('InstallModule.install', 'Расширение Memcache'),
                false,
                extension_loaded("memcache") || extension_loaded("memcached"),
                '<a href="http://www.yiiframework.com/doc/api/CMemCache">CMemCache</a>',
                extension_loaded("memcached") ? Yii::t(
                    'InstallModule.install',
                    'Чтобы использовать memcached установите значение свойства <a href="http://www.yiiframework.com/doc/api/CMemCache#useMemcached-detail">CMemCache::useMemcached</a> равным <code>true</code>.'
                ) : '',
            ),
            array(
                Yii::t('InstallModule.install', 'Расширение APC'),
                false,
                extension_loaded("apc"),
                '<a href="http://www.yiiframework.com/doc/api/CApcCache">CApcCache</a>',
                Yii::t(
                    'InstallModule.install',
                    'Акселератор PHP — программа, ускоряющая исполнение сценариев PHP интерпретатором путём кэширования их байткода. <b>Необязательно</b>.'
                ),
            ),
            array(
                Yii::t('InstallModule.install', 'Расширение Mcrypt'),
                false,
                extension_loaded("mcrypt"),
                '<a href="http://www.yiiframework.com/doc/api/CSecurityManager">CSecurityManager</a>',
                Yii::t('InstallModule.install', 'Требуется для работы методов шифрования и дешифрации.'),
            ),
            array(
                Yii::t('InstallModule.install', 'Расширение SOAP'),
                false,
                extension_loaded("soap"),
                '<a href="http://www.yiiframework.com/doc/api/CWebService">CWebService</a>,
                 <a href="http://www.yiiframework.com/doc/api/CWebServiceAction">CWebServiceAction</a>',
                Yii::t('InstallModule.install', '<b>Необязательно</b>.'),
            ),
            array(
                Yii::t('InstallModule.install', 'Расширение mbstring'),
                true,
                extension_loaded("mbstring"),
                '<a href="http://php.net/manual/ru/ref.mbstring.php">Многобайтные строки</a>',
                Yii::t('InstallModule.install', 'Функции для работы с многобайтными строками')
            ),
            array(
                Yii::t(
                    'InstallModule.install',
                    'Расширение GD<br />с поддержкой FreeType<br />или ImageMagick<br />с поддержкой PNG'
                ),
                false,
                '' === $message = $this->_checkCaptchaSupport(),
                '<a href="http://www.yiiframework.com/doc/api/CCaptchaAction">CCaptchaAction</a>',
                $message
            ),
            array(
                Yii::t('InstallModule.install', 'Расширение Ctype'),
                true,
                extension_loaded("ctype"),
                '<a href="http://www.yiiframework.com/doc/api/CDateFormatter">CDateFormatter</a>,
                 <a href="http://www.yiiframework.com/doc/api/CDateFormatter">CDateTimeParser</a>,
                 <a href="http://www.yiiframework.com/doc/api/CTextHighlighter">CTextHighlighter</a>,
                 <a href="http://www.yiiframework.com/doc/api/CHtmlPurifier">CHtmlPurifier</a>',
                ''
            ),
            array(
                Yii::t('InstallModule.install', 'Конфигурационные опциия safe_mode'),
                true,
                !ini_get('safe_mode'),
                '<a href="http://php.net/manual/ru/ini.sect.safe-mode.php">Безопасность и безопасный режим</a>',
                Yii::t('InstallModule.install', 'Необходимо отключить директиву safe_mode.'),
            ),
        );

        $result = true;

        foreach ($requirements as $i => $requirement) {
            if ($requirement[1] && !$requirement[2]) {
                $result = false;
            }
        }

        if ($result) {
            $this->_markFinished(Yii::app()->controller->action->id);
        }

        $this->render(
            '_view',
            array(
                'data' => array(
                    'requirements' => $requirements,
                    'result' => $result,
                )
            )
        );
    }

    /**
     * Проверка переменных окружения сервера:
     * (приватные методы функции, начинаются с подчёркивания)
     *
     * @return nothing
     **/
    private function _checkServerVar()
    {
        $vars = array(
            'HTTP_HOST',
            'SERVER_NAME',
            'SERVER_PORT',
            'SCRIPT_NAME',
            'SCRIPT_FILENAME',
            'PHP_SELF',
            'HTTP_ACCEPT',
            'HTTP_USER_AGENT'
        );
        $missing = array();
        foreach ($vars as $var) {
            if (!isset($_SERVER[$var])) {
                $missing[] = $var;
            }
        }
        if (!empty($missing)) {
            return Yii::t(
                'InstallModule.install',
                'Переменная $_SERVER не содержит {vars}.',
                array('{vars}' => implode(', ', $missing))
            );
        }
        if (!isset($_SERVER["REQUEST_URI"]) && isset($_SERVER["QUERY_STRING"])) {
            return Yii::t(
                'InstallModule.install',
                'Должна существовать хотя бы одна из серверных переменных: $_SERVER["REQUEST_URI"] или $_SERVER["QUERY_STRING"].'
            );
        }
        if (!isset($_SERVER["PATH_INFO"]) && strpos($_SERVER["PHP_SELF"], $_SERVER["SCRIPT_NAME"]) !== 0) {
            return Yii::t(
                'InstallModule.install',
                'Не удалось получить информацию о пути. Пожалуйста, проверьте, содержится ли корректное значение в переменной $_SERVER["PATH_INFO"] (или $_SERVER["PHP_SELF"] и $_SERVER["SCRIPT_NAME"]).'
            );
        }
        return '';
    }

    /**
     * Проверяем возможность использования расширения PHP GD:
     * (приватные методы функции, начинаются с подчёркивания)
     *
     * @return string
     **/
    private function _checkCaptchaSupport()
    {
        if (extension_loaded('imagick')) {
            $imagick = new Imagick();
            $imagickFormats = $imagick->queryFormats('PNG');
        }
        if (extension_loaded('gd')) {
            $gdInfo = gd_info();
        }
        if (isset($imagickFormats) && in_array('PNG', $imagickFormats)) {
            return '';
        } else {
            if (isset($gdInfo)) {
                if ($gdInfo['FreeType Support']) {
                    return '';
                }
                return Yii::t('InstallModule.install', 'Расширение GD установлено<br />без поддержки FreeType');
            }
        }
        return Yii::t('InstallModule.install', 'Расширение GD или ImageMagick не установлены');
    }

    /**
     * Экшен для настройки БД:
     *
     * @return nothing
     **/
    public function actionDbsettings()
    {
        $this->_markFinished('requirements');

        $dbConfFile = Yii::app()->basePath . '/config/' . 'db.php';

        $form = new InstallForm('dbSettings');

        if (isset($this->session['InstallForm']['dbSettings'])) {
            $form->setAttributes($this->session['InstallForm']['dbSettings']);
            if (($form->validate()) && ($this->session['InstallForm']['dbSettingsStep'] === true)) {
                $this->session['InstallForm'] = array_merge(
                    $this->session['InstallForm'],
                    array(
                        'dbSettings' => $form->attributes,
                        'dbSettingsStep' => false,
                        'dbSettingsFile' => true,
                    )
                );
                $this->_setSession();
                $this->_markFinished('dbsettings');
                $this->redirect(array('/install/default/modulesinstall'));
            }
        }

        if (Yii::app()->request->isPostRequest && isset($_POST['InstallForm'])) {
            $form->setAttributes($_POST['InstallForm']);

            if ($form->validate()) {
                $socket = ($form->socket == '') ? '' : 'unix_socket=' . $form->socket . ';';
                $port = ($form->port == '') ? '' : 'port=' . $form->port . ';';
                $dbName = empty($form->createDb) ? 'dbname=' . $form->dbName : '';
                $dbTypes = $form->getDbTypes();
                $dbType = (isset($dbTypes[$form->dbType])
                    ? $dbTypes[$form->dbType]
                    : $dbTypes[InstallForm::DB_MYSQL]);

                $socket = ($form->socket == '') ? '' : 'unix_socket=' . $form->socket . ';';
                $port = ($form->port == '') ? '' : 'port=' . $form->port . ';';
                if ($form->dbType != InstallForm::DB_SQLITE) {
                    $connectionString = "{$dbType}:host={$form->host};{$port}{$socket}{$dbName}";
                } else {
                    $connectionString = $form->dbConString;
                }

                try {
                    if ($form->dbType != InstallForm::DB_SQLITE) {
                        $connection = new CDbConnection($connectionString, $form->dbUser, $form->dbPassword);
                    } else {
                        $connection = new CDbConnection($connectionString);
                    }
                } catch (Exception $e) {
                    $form->addError(
                        '',
                        Yii::t(
                            'InstallModule.install',
                            'С указанными параметрами подключение к БД не удалось выполнить!'
                        ) . '<br />' . $connectionString . '<br />' . $e->getMessage()
                    );
                    Yii::log($e->__toString(), CLogger::LEVEL_ERROR);
                    Yii::log($e->getTraceAsString(), CLogger::LEVEL_ERROR);
                }

                if ($form->createDb && $form->dbType != InstallForm::DB_SQLITE) {
                    try {
                        $sql = 'CREATE DATABASE ' . ($connection->schema instanceof CMysqlSchema ? ' `' . $form->dbName . '` CHARACTER SET=utf8' : $form->dbName);
                        $connection->createCommand($sql)->execute();
                        $connectionString .= 'dbname=' . $form->dbName;
                    } catch (Exception $e) {
                        $form->addError(
                            '',
                            Yii::t(
                                'InstallModule.install',
                                'Не удалось создать БД!'
                            ) . '<br />' . $connectionString . '<br />' . $e->getMessage()
                        );
                        Yii::log($e->__toString(), CLogger::LEVEL_ERROR);
                        Yii::log($e->getTraceAsString(), CLogger::LEVEL_ERROR);
                    }
                }

                $connection->connectionString = $connectionString;

                try {
                    if ($form->dbType != InstallForm::DB_SQLITE) {
                        $connection->username = $form->dbUser;
                        $connection->password = $form->dbPassword;
                        $connection->emulatePrepare = true;
                        $connection->charset = 'utf8';
                    }
                    $connection->active = true;
                } catch (Exception $e) {
                    $form->addError(
                        '',
                        Yii::t(
                            'InstallModule.install',
                            'Не удалось подключиться к БД!'
                        ) . '<br />' . $connectionString . '<br />' . $e->getMessage()
                    );
                    Yii::log($e->__toString(), CLogger::LEVEL_ERROR);
                    Yii::log($e->getTraceAsString(), CLogger::LEVEL_ERROR);
                }

                if (!$form->hasErrors()) {

                    $connection->tablePrefix = $form->tablePrefix;

                    Yii::app()->setComponent('db', $connection);
                    $dbParams = ($form->dbType != InstallForm::DB_SQLITE)
                        ? array(
                            'class' => 'CDbConnection',
                            'connectionString' => $connectionString,
                            'username' => $form->dbUser,
                            'password' => $form->dbPassword,
                            'emulatePrepare' => true,
                            'charset' => 'utf8',
                            'enableParamLogging' => 0,
                            'enableProfiling' => 0,
                            'schemaCachingDuration' => 108000,
                            'tablePrefix' => $form->tablePrefix,
                        )
                        : array(
                            'class' => 'CDbConnection',
                            'connectionString' => $connectionString,
                            'tablePrefix' => $form->tablePrefix,
                        );

                    $dbConfString = "<?php\n return " . var_export($dbParams, true) . ";\n";

                    $fh = fopen($dbConfFile, 'w+');
                    if (!$fh) {
                        $form->addError(
                            '',
                            Yii::t(
                                'InstallModule.install',
                                "Не могу открыть файл '{file}' для записии!",
                                array('{file}' => $dbConfFile)
                            )
                        );
                    } else {
                        if (fwrite($fh, $dbConfString) && fclose($fh)) {

                            $this->session['InstallForm'] = array_merge(
                                $this->session['InstallForm'],
                                array(
                                    'dbSettings' => $form->attributes,
                                    'dbSettingsStep' => true,
                                    'dbSettingsFile' => true,
                                )
                            );

                            $this->_setSession();

                            $this->redirect(array('/install/default/dbsettings'));
                        } else {
                            $form->addError(
                                '',
                                Yii::t(
                                    'InstallModule.install',
                                    "Произошла ошибка записи в файл '{file}'!",
                                    array('{file}' => $dbConfFile)
                                )
                            );
                        }
                    }
                }
            }
        }

        $result = false;

        if (file_exists($dbConfFile) && is_writable($dbConfFile)) {
            $result = true;
        }

        $this->render(
            '_view',
            array(
                'data' => array(
                    'model' => $form,
                    'result' => $result,
                    'file' => $dbConfFile,
                )
            )
        );
    }

    /**
     * Экшен "Установки модулей"
     *
     * @return nothing
     **/
    public function actionModulesinstall()
    {
        $error = false;

        $modules = $this->yupe->getModulesDisabled();
        // Не выводить модуль install и yupe
        unset($modules['install']);

        if (Yii::app()->request->isPostRequest) {
            $this->session['InstallForm'] = array_merge(
                $this->session['InstallForm'],
                array(
                    'moduleToInstall' => $_POST,
                    'modulesInstallStep' => true,
                )
            );

            $this->_setSession();
            $this->_markFinished('modulesinstall');
            $this->redirect($this->createUrl('modulesinstall'));
        }

        if ((isset($this->session['InstallForm']['moduleToInstall'])) && ($this->session['InstallForm']['modulesInstallStep'] === true) && ($_POST = $this->session['InstallForm']['moduleToInstall'])) {
            $this->session['InstallForm'] = array_merge(
                $this->session['InstallForm'],
                array(
                    'moduleToInstall' => $_POST,
                    'modulesInstallStep' => false,
                )
            );
            $this->_setSession();
            $modulesByName = $toInstall = array();

            foreach ($modules as &$m) {
                $modulesByName[$m->id] = $m;
                if ($m->getIsNoDisable() || (isset($_POST['module_' . $m->id]) && $_POST['module_' . $m->id])) {
                    $toInstall[$m->id] = $m;
                }
            }
            unset($m);

            foreach ($toInstall as $m) {
                $deps = $m->getDependencies();
                if (!empty($deps)) {
                    foreach ($deps as $dep) {
                        if (!isset($toInstall[$dep])) {
                            Yii::app()->user->setFlash(
                                YFlashMessages::ERROR_MESSAGE,
                                Yii::t(
                                    'InstallModule.install',
                                    'Модуль "{module}" зависит от модуля "{dep}", который не активирован.',
                                    array(
                                        '{module}' => $m->name,
                                        '{dep}' => isset($modulesByName[$dep]) ? $modulesByName[$dep]->name : $dep
                                    )
                                )
                            );
                            $error = true;
                            break;
                        }
                    }
                }
            }
            if (!$error) {
                // Переносим конфигурационные файлы не устанавливаемых модулей в back-папку
                $files = glob($this->yupe->getModulesConfig() . "*.php");
                foreach ($files as $file) {
                    $name = pathinfo($file, PATHINFO_FILENAME);
                    if ($name == 'yupe') {
                        continue;
                    }

                    $fileModule = $this->yupe->getModulesConfigDefault($name);
                    $fileConfig = $this->yupe->getModulesConfig($name);
                    $fileConfigBack = $this->yupe->getModulesConfigBack($name);

                    if ($name != 'yupe' && ((!(@is_file($fileModule) && @md5_file($fileModule) == @md5_file(
                                            $fileConfig
                                        )) && !@copy($fileConfig, $fileConfigBack)) || !@unlink($fileConfig))
                    ) {
                        $error = true;
                        Yii::app()->user->setFlash(
                            YFlashMessages::ERROR_MESSAGE,
                            Yii::t(
                                'InstallModule.install',
                                'Произошла ошибка установки модулей - ошибка копирования файла в папку modulesBack!'
                            )
                        );
                        break;
                    }
                }
            }

            // Продолжаем установку модулей
            if (!$error) {
                return $this->render('begininstall', array('modules' => $toInstall));
            }
        }

        $this->render(
            '_view',
            array(
                'data' => array(
                    'modules' => $modules
                )
            )
        );
    }

    /**
     * Запись в "веб-лог" на странице:
     *
     * @param class $module   - клас модуля
     * @param string $msg      - сообщение
     * @param string $category - тип сообщения
     *
     * @return void вывод html
     */
    private function _logMessage($module, $msg, $category = 'notice')
    {
        $color = array(
            'warning' => 'FF9600',
            'error' => 'FF0000',
        );

        $msg = CHtml::tag("b", array(), $module->name . ": ") . $msg;
        if (isset($color[$category])) {
            $msg = CHtml::openTag("span", array('style' => ('color: #' . $color[$category]))) . $msg . CHtml::closeTag(
                    "span"
                );
        }
        echo $msg . "<br />";
    }

    /**
     * Экшен установки модуля:
     *
     * @param string $name - имя модуля
     *
     * @return html
     **/
    public function actionModuleinstall($name = null)
    {
        $modules = $this->yupe->getModulesDisabled();

        if (empty($name) || !isset($modules[$name])) {
            throw new CHttpException(404, Yii::t(
                'InstallModule.install',
                'Указанный модуль {name} не найден!',
                array('{name}' => $name)
            ));
        }

        ob_start();
        ob_implicit_flush(false);

        $module = $modules[$name];

        $this->_logMessage($module, Yii::t('InstallModule.install', 'Обновляем базу модуля до актуального состояния!'));

        try {
            $module->getInstall();
            $this->_logMessage($module, Yii::t('InstallModule.install', 'Модуль установлен!'));
            echo CJSON::encode(array('installed' => array($module->getId()), 'log' => ob_get_clean()));
        } catch (Exception $e) {
            $this->_logMessage($module, $e->getMessage(), "error");
            echo ob_get_clean();
        }
        Yii::app()->end();
    }

    /**
     * Экшен создания учетной записи администратора:
     *
     * @return nothing
     **/
    public function actionCreateuser()
    {
        $model = new InstallForm('createUser');

        if (isset($this->session['InstallForm']['createUser'])) {
            $model->setAttributes($this->session['InstallForm']['createUser']);
            if ($model->validate() && $this->session['InstallForm']['createUserStep'] === true) {
                $this->session['InstallForm'] = array_merge(
                    $this->session['InstallForm'],
                    array(
                        'createUser' => $model->attributes,
                        'createUserStep' => false,
                    )
                );
                $this->_markFinished('createuser');
                $this->_setSession();
                $this->redirect(array('/install/default/sitesettings'));
            }
        }

        if (Yii::app()->request->isPostRequest && isset($_POST['InstallForm'])) {
            // Сбрасываем сессию текущего пользователя, может поменяться id
            Yii::app()->user->clearStates();

            $model->setAttributes($_POST['InstallForm']);

            if ($model->validate()) {
                $user = new User;

                $user->deleteAll();

                $salt = $user->generateSalt();

                $user->setAttributes(
                    array(
                        'nick_name' => $model->userName,
                        'email' => $model->userEmail,
                        'salt' => $salt,
                        'gender' => 0,
                        'password' => User::model()->hashPassword($model->userPassword, $salt),
                        'registration_date' => YDbMigration::expression('NOW()'),
                        'registration_ip' => Yii::app()->request->userHostAddress,
                        'activation_ip' => Yii::app()->request->userHostAddress,
                        'access_level' => User::ACCESS_LEVEL_ADMIN,
                        'status' => User::STATUS_ACTIVE,
                        'email_confirm' => User::EMAIL_CONFIRM_YES,
                    )
                );

                if ($user->save()) {
                    $login = new LoginForm;
                    $login->email = $model->userEmail;
                    $login->password = $model->userPassword;
                    $login->authenticate();

                    Yii::app()->user->setFlash(
                        YFlashMessages::NOTICE_MESSAGE,
                        Yii::t('InstallModule.install', 'Администратор успешно создан!')
                    );

                    $this->session['InstallForm'] = array_merge(
                        $this->session['InstallForm'],
                        array(
                            'createUser' => $model->attributes,
                            'createUserStep' => true,
                        )
                    );

                    $this->_setSession();

                    $this->redirect(array('/install/default/createuser'));
                } else {
                    Yii::app()->user->setFlash(
                        YFlashMessages::ERROR_MESSAGE,
                        print_r($user->getErrors(), true)
                    );
                }
            }
        }
        $this->render(
            '_view',
            array(
                'data' => array(
                    'model' => $model
                )
            )
        );
    }

    /**
     * Экшен начальной настройки проекта:
     *
     * @return nothing
     **/
    public function actionSitesettings()
    {
        $model = new InstallForm('siteSettings');

        if (isset($this->session['InstallForm']['siteSettings'])) {
            $model->setAttributes($this->session['InstallForm']['siteSettings']);
            if ($model->validate() && $this->session['InstallForm']['siteSettingsStep'] === true) {
                $this->session['InstallForm'] = array_merge(
                    $this->session['InstallForm'],
                    array(
                        'siteSettings' => $model->attributes,
                        'siteSettingsStep' => false,
                    )
                );
                $this->_markFinished('sitesettings');
                $this->_setSession();
                $this->redirect(array('/install/default/finish'));
            }
        }

        if ((Yii::app()->request->isPostRequest) && (isset($_POST['InstallForm']))) {
            $model->setAttributes($_POST['InstallForm']);

            if ($model->validate()) {
                $transaction = Yii::app()->db->beginTransaction();

                try {
                    Settings::model()->deleteAll();

                    $user = User::model()->admin()->findAll();

                    foreach (array(
                                 'siteDescription',
                                 'siteName',
                                 'siteKeyWords',
                                 'email',
                                 'theme',
                                 'backendTheme'
                             ) as $param) {
                        $settings = new Settings;
                        $model->email = $model->siteEmail;

                        $settings->setAttributes(
                            array(
                                'module_id' => 'yupe',
                                'param_name' => $param,
                                'param_value' => $model->$param,
                                'user_id' => $user[0]->id,
                            )
                        );

                        if ($settings->save()) {
                            continue;
                        } else {
                            throw new CDbException(print_r($settings->getErrors(), true));
                        }
                    }

                    $transaction->commit();

                    Yii::app()->user->setFlash(
                        YFlashMessages::NOTICE_MESSAGE,
                        Yii::t('InstallModule.install', 'Настройки сайта успешно сохранены!')
                    );

                    // попробуем создать каталог assets
                    $assetsPath = dirname(Yii::app()->request->getScriptFile()) . '/' . CAssetManager::DEFAULT_BASEPATH;

                    if (!is_dir($assetsPath)) {
                        @mkdir($assetsPath);
                    }

                    $this->session['InstallForm'] = array_merge(
                        $this->session['InstallForm'],
                        array(
                            'siteSettings' => $model->attributes,
                            'siteSettingsStep' => true,
                        )
                    );
                    $this->_setSession();
                    $this->redirect(array('/install/default/sitesettings'));
                } catch (CDbException $e) {
                    $transaction->rollback();

                    Yii::app()->user->setFlash(
                        YFlashMessages::ERROR_MESSAGE,
                        $e->__toString()
                    );

                    Yii::log($e->__toString(), CLogger::LEVEL_ERROR);

                    $this->redirect(array('/install/default/sitesettings/'));
                }
            }
        } else {
            $model->siteEmail = $model->emailName;
        }
        $this->render(
            '_view',
            array(
                'data' => array(
                    'model' => $model,
                    'themes' => $this->yupe->getThemes(),
                    'backendThemes' => $this->yupe->getThemes(true)
                )
            )
        );
    }

    /**
     * Экшен окончание установки:
     *
     * @return nothing
     **/
    public function actionFinish()
    {
        try {
            Yii::app()->getModule('install')->getActivate();
            Yii::app()->user->setFlash(
                YFlashMessages::NOTICE_MESSAGE,
                Yii::t('InstallModule.install', "Модуль install отключен!")
            );
        } catch (Exception $e) {
            Yii::app()->user->setFlash(
                YFlashMessages::ERROR_MESSAGE,
                $e->getMessage()
            );
        }

        $this->render('_view');
    }
}
