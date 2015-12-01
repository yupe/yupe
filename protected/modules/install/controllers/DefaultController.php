<?php
/**
 * Default Install Controller
 *
 * @category YupeControllers
 * @package yupe.modules.install.controllers
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @version  0.0.1
 * @link     http://yupe.ru
 **/

use yupe\models\Settings;

class DefaultController extends yupe\components\controllers\BackController
{
    /**
     * Переменная названия текущего шага:
     **/
    public $stepName;

    /**
     * Параметры из сессии:
     **/
    public $session = [];

    /**
     * Функция фильтров:
     *
     * @return mixed filters
     **/
    public function filters()
    {
        return [];
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
            Yii::app()->session['InstallForm'] = [];
        }
        $this->session['InstallForm'] = Yii::app()->session['InstallForm'];

        $this->pageTitle = Yii::t('InstallModule.install', 'installation of Yupe!');

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
            [
                $actionId.'Finished' => true,
            ]
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
        if (!$isStepFinished && !in_array($action->id, ['index', 'moduleinstall'])) {
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
        $this->session['InstallForm'] = [];
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
        $app = Yii::getPathOfAlias('application');
        $dp = DIRECTORY_SEPARATOR;

        $requirements = [
            [
                Yii::t('InstallModule.install', 'Assets folder'),
                $this->_checkWritable($webRoot.'/assets/'),
                Yii::t(
                    'InstallModule.install',
                    'You need to set write permissions for the directory {folder}assets',
                    [
                        '{folder}' => $webRoot.$dp,
                    ]
                ),
            ],
            [
                Yii::t('InstallModule.install', 'Runtime folder'),
                $this->_checkWritable($app.'/runtime/'),
                Yii::t(
                    'InstallModule.install',
                    'You need to set write permissions for the directory {folder}',
                    [
                        '{folder}' => $app.$dp.'runtime',
                    ]
                ),
            ],
            [
                Yii::t('InstallModule.install', 'Uploads folder'),
                $this->_checkWritable($webRoot.'/uploads/'),
                Yii::t(
                    'InstallModule.install',
                    'You need to set write permissions for the directory {folder}',
                    [
                        '{folder}' => $webRoot.$dp.'uploads',
                    ]
                ),
            ],
            [
                Yii::t('InstallModule.install', 'Modules folder'),
                $this->_checkWritable($app.'/config/modules/'),
                Yii::t(
                    'InstallModule.install',
                    'You need to set write permissions for the directory {folder}',
                    [
                        '{folder}' => $app.$dp.'config'.$dp.'modules',
                    ]
                ),
            ],
            [
                Yii::t('InstallModule.install', 'ModulesBack folder'),
                $this->_checkWritable($app.'/config/modulesBack/'),
                Yii::t(
                    'InstallModule.install',
                    'You need to set write permissions for the directory {folder}',
                    [
                        '{folder}' => $app.$dp.'config'.$dp.'modulesBack',
                    ]
                ),
            ],
            [
                Yii::t('InstallModule.install', 'File db.php'),
                $this->_checkConfigFileWritable(
                    $app.$dp.'config/db.back.php',
                    $app.$dp.'config/db.php'
                ),
                Yii::t(
                    'InstallModule.install',
                    'You should copy {from file} to {to file} and give it permission to write',
                    [
                        '{from file}' => $app.$dp.'config'.$dp.'db.back.php',
                        '{to file}' => $app.$dp.'config'.$dp.'db.php',
                    ]
                ),
            ],
        ];

        $result = true;
        $commentOk = Yii::t('InstallModule.install', 'Everything is fine!');

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
            [
                [
                    Yii::t('InstallModule.install', 'Activation of Yupe core!'),
                    $result,
                    (!$result)
                        ? Yii::t(
                        'InstallModule.install',
                        'At startup errors occured, please check the permissions for the all the files and directories (see the above errors)'
                    )
                        : $commentOk,
                ],
            ]
        );

        $this->render(
            '_view',
            [
                'data' => [
                    'requirements' => $requirements,
                    'result' => $result,
                ],
            ]
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
        return $this->yupe->getActivate(true);
    }

    /**
     * Экшен "Проверки системных требований"
     *
     * @return nothing
     **/
    public function actionRequirements()
    {
        $requirements = [
            [
                Yii::t('InstallModule.install', 'РНР version'),
                true,
                version_compare(PHP_VERSION, "5.4", ">="),
                '<a href="http://www.yiiframework.com">Yii Framework</a>',
                Yii::t('InstallModule.install', 'Need PHP version 5.4 and above.'),
            ],
            [
                Yii::t('InstallModule.install', 'Расширение json'),
                true,
                extension_loaded("json"),
                'php_json',
                Yii::t('InstallModule.install', 'Функции для работы с json'),
            ],
            [
                Yii::t('InstallModule.install', 'Zend OPcache'),
                false,
                extension_loaded('Zend OPcache'),
                '<a href="http://php.net/manual/ru/book.opcache.php">Zend OPcache',
                Yii::t('InstallModule.install', 'Zend OPcache required to optimize and speed up your project.'),
            ],
            [
                Yii::t('InstallModule.install', 'The variable $_SERVER'),
                true,
                '' === $message = $this->_checkServerVar(),
                '<a href="http://www.yiiframework.com">Yii Framework</a>',
                $message,
            ],
            [
                Yii::t('InstallModule.install', 'Reflection extension'),
                true,
                class_exists('Reflection', false),
                '<a href="http://www.yiiframework.com">Yii Framework</a>',
                '',
            ],
            [
                Yii::t('InstallModule.install', 'PCRE extension'),
                true,
                extension_loaded("pcre"),
                '<a href="http://www.yiiframework.com">Yii Framework</a>',
                '',
            ],
            [
                Yii::t('InstallModule.install', 'SPL extension'),
                true,
                extension_loaded("SPL"),
                '<a href="http://www.yiiframework.com">Yii Framework</a>',
                '',
            ],
            [
                Yii::t('InstallModule.install', 'DOM extension'),
                true,
                extension_loaded("dom"),
                '<a href="http://www.yiiframework.com/doc/api/CHtmlPurifier">CHtmlPurifier</a>,
                 <a href="http://www.yiiframework.com/doc/api/CWsdlGenerator">CWsdlGenerator</a>',
                '',
            ],
            [
                Yii::t('InstallModule.install', 'PDO extension'),
                true,
                extension_loaded('pdo'),
                Yii::t(
                    'InstallModule.install',
                    'All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-classes</a>'
                ),
                '',
            ],
            [
                Yii::t('InstallModule.install', 'PDO MySQL extension'),
                false,
                extension_loaded('pdo_mysql'),
                Yii::t(
                    'InstallModule.install',
                    'All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-classes</a>'
                ),
                Yii::t('InstallModule.install', 'Required for MySQL DB.'),
            ],
            [
                Yii::t('InstallModule.install', 'Memcache extension'),
                false,
                extension_loaded("memcache") || extension_loaded("memcached"),
                '<a href="http://www.yiiframework.com/doc/api/CMemCache">CMemCache</a>',
                extension_loaded("memcached") ? Yii::t(
                    'InstallModule.install',
                    'To use memcached, set the value of the property {useMemcachedLink} equal {code_true}.',
                    [
                        '{useMemcachedLink}' => '<a href="http://www.yiiframework.com/doc/api/CMemCache#useMemcached-detail">CMemCache::useMemcached</a>',
                        '{code_true}' => '<code>true</code>',
                    ]
                ) : '',
            ],
            [
                Yii::t('InstallModule.install', 'APC extension'),
                false,
                extension_loaded("apc"),
                '<a href="http://www.yiiframework.com/doc/api/CApcCache">CApcCache</a>',
                Yii::t(
                    'InstallModule.install',
                    'The Alternative PHP Cache (APC) is a free and open opcode cache for PHP. Its goal is to provide a free, open, and robust framework for caching and optimizing PHP intermediate code. {b}Optional{/b}.',
                    [
                        '{b}' => '<b>',
                        '{/b}' => '</b>',
                    ]
                ),
            ],
            [
                Yii::t('InstallModule.install', 'Mcrypt extension'),
                false,
                extension_loaded("mcrypt"),
                '<a href="http://www.yiiframework.com/doc/api/CSecurityManager">CSecurityManager</a>',
                Yii::t('InstallModule.install', 'Required for encryption and decryption methods.'),
            ],
            [
                Yii::t('InstallModule.install', 'mbstring extension'),
                true,
                extension_loaded("mbstring"),
                '<a href="http://php.net/manual/ru/ref.mbstring.php">'.Yii::t(
                    'InstallModule.install',
                    'Multibyte strings'
                ).'</a>',
                Yii::t('InstallModule.install', 'Multibyte String Functions'),
            ],
            [
                Yii::t(
                    'InstallModule.install',
                    'GD extension {br} with support for FreeType {br} or ImageMagick {br} supporting PNG',
                    [
                        '{br}' => '<br />',
                    ]
                ),
                false,
                '' === $message = $this->_checkCaptchaSupport(),
                '<a href="http://www.yiiframework.com/doc/api/CCaptchaAction">CCaptchaAction</a>',
                $message,
            ],
            [
                Yii::t('InstallModule.install', 'Ctype extension'),
                true,
                extension_loaded("ctype"),
                '<a href="http://www.yiiframework.com/doc/api/CDateFormatter">CDateFormatter</a>,
                 <a href="http://www.yiiframework.com/doc/api/CDateFormatter">CDateTimeParser</a>,
                 <a href="http://www.yiiframework.com/doc/api/CTextHighlighter">CTextHighlighter</a>,
                 <a href="http://www.yiiframework.com/doc/api/CHtmlPurifier">CHtmlPurifier</a>',
                '',
            ],
            [
                Yii::t('InstallModule.install', 'Configuration option safe_mode'),
                true,
                !ini_get('safe_mode'),
                '<a href="http://php.net/manual/ru/ini.sect.safe-mode.php">'.
                Yii::t('InstallModule.install', 'Security and Safe Mode').
                '</a>',
                Yii::t('InstallModule.install', 'You should disable the directive safe_mode.'),
            ],
        ];

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
            [
                'data' => [
                    'requirements' => $requirements,
                    'result' => $result,
                ],
            ]
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
        $vars = [
            'HTTP_HOST',
            'SERVER_NAME',
            'SERVER_PORT',
            'SCRIPT_NAME',
            'SCRIPT_FILENAME',
            'PHP_SELF',
            'HTTP_ACCEPT',
            'HTTP_USER_AGENT',
        ];
        $missing = [];
        foreach ($vars as $var) {
            if (!isset($_SERVER[$var])) {
                $missing[] = $var;
            }
        }
        if (!empty($missing)) {
            return Yii::t(
                'InstallModule.install',
                'The variable $_SERVER does not contain {vars}.',
                ['{vars}' => implode(', ', $missing)]
            );
        }
        if (!isset($_SERVER["REQUEST_URI"]) && isset($_SERVER["QUERY_STRING"])) {
            return Yii::t(
                'InstallModule.install',
                'There should be at least one server variables: {vars}.',
                [
                    '{vars}' => '$_SERVER["REQUEST_URI"] или $_SERVER["QUERY_STRING"]',
                ]
            );
        }
        if (!isset($_SERVER["PATH_INFO"]) && strpos($_SERVER["PHP_SELF"], $_SERVER["SCRIPT_NAME"]) !== 0) {
            return Yii::t(
                'InstallModule.install',
                'Could not obtain information about the location. Please check whether the correct value in the variable {path_info} (or {php_self} and {script_name}).',
                [
                    '{path_info}' => '$_SERVER["PATH_INFO"]',
                    '{php_self}' => '$_SERVER["PHP_SELF"]',
                    '{script_name}' => '$_SERVER["SCRIPT_NAME"]',
                ]
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

                return Yii::t(
                    'InstallModule.install',
                    'GD extension installed {br} without the support of FreeType',
                    [
                        '{br}' => '<br />',
                    ]
                );
            }
        }

        return Yii::t('InstallModule.install', 'ImageMagick or GD extension is not installed');
    }

    /**
     * Экшен для настройки БД:
     *
     * @return nothing
     **/
    public function actionDbsettings()
    {
        $this->_markFinished('requirements');

        $dbConfFile = Yii::app()->basePath.'/config/'.'db.php';

        $form = new InstallForm('dbSettings');

        if (isset($this->session['InstallForm']['dbSettings'])) {
            $form->setAttributes($this->session['InstallForm']['dbSettings']);
            if (($form->validate()) && ($this->session['InstallForm']['dbSettingsStep'] === true)) {
                $this->session['InstallForm'] = array_merge(
                    $this->session['InstallForm'],
                    [
                        'dbSettings' => $form->attributes,
                        'dbSettingsStep' => false,
                        'dbSettingsFile' => true,
                    ]
                );
                $this->_setSession();
                $this->_markFinished('dbsettings');
                $this->redirect(['/install/default/modulesinstall']);
            }
        }

        if (Yii::app()->getRequest()->getIsPostRequest() && isset($_POST['InstallForm'])) {
            $form->setAttributes($_POST['InstallForm']);

            if ($form->validate()) {
                $socket = ($form->socket == '') ? '' : 'unix_socket='.$form->socket.';';
                $port = ($form->port == '') ? '' : 'port='.$form->port.';';
                $dbName = empty($form->createDb) ? 'dbname='.$form->dbName : '';
                $dbTypes = $form->getDbTypes();
                $dbType = (isset($dbTypes[$form->dbType])
                    ? $dbTypes[$form->dbType]
                    : $dbTypes[InstallForm::DB_MYSQL]);

                $socket = ($form->socket == '') ? '' : 'unix_socket='.$form->socket.';';
                $port = ($form->port == '') ? '' : 'port='.$form->port.';';
                $connectionString = "{$dbType}:host={$form->host};{$port}{$socket}{$dbName}";

                try {
                    $connection = new CDbConnection($connectionString, $form->dbUser, $form->dbPassword);

                } catch (Exception $e) {
                    $form->addError(
                        '',
                        Yii::t(
                            'InstallModule.install',
                            'Couldn\'t connect to DB with these params!'
                        ).'<br />'.$connectionString.'<br />'.$e->getMessage()
                    );
                    Yii::log($e->__toString(), CLogger::LEVEL_ERROR);
                    Yii::log($e->getTraceAsString(), CLogger::LEVEL_ERROR);
                }

                if ($form->createDb) {
                    try {
                        $sql = 'CREATE DATABASE '.($connection->schema instanceof CMysqlSchema ? ' `'.$form->dbName.'` CHARACTER SET=utf8' : $form->dbName);
                        $connection->createCommand($sql)->execute();
                        $connectionString .= 'dbname='.$form->dbName;
                    } catch (Exception $e) {
                        $form->addError(
                            '',
                            Yii::t(
                                'InstallModule.install',
                                'Failed to create the database!'
                            ).'<br />'.$connectionString.'<br />'.$e->getMessage()
                        );
                        Yii::log($e->__toString(), CLogger::LEVEL_ERROR);
                        Yii::log($e->getTraceAsString(), CLogger::LEVEL_ERROR);
                    }
                }

                $connection->connectionString = $connectionString;

                try {
                    $connection->username = $form->dbUser;
                    $connection->password = $form->dbPassword;
                    $connection->emulatePrepare = true;
                    $connection->charset = 'utf8';

                    if (!$form->hasErrors()) {

                        $connection->tablePrefix = $form->tablePrefix;

                        Yii::app()->setComponent('db', $connection);
                        $dbParams = [
                            'class' => 'CDbConnection',
                            'connectionString' => $connectionString,
                            'username' => $form->dbUser,
                            'password' => $form->dbPassword,
                            'emulatePrepare' => true,
                            'charset' => 'utf8',
                            'enableParamLogging' => "{debug}",
                            'enableProfiling' => "{debug}",
                            'schemaCachingDuration' => 108000,
                            'tablePrefix' => $form->tablePrefix,
                            'pdoClass' => 'yupe\extensions\NestedPDO',
                        ];

                        $dbConfString = "<?php\n return "
                            .str_replace(
                                "'{debug}'",
                                "defined('YII_DEBUG') && YII_DEBUG ? true : 0",
                                var_export($dbParams, true)
                            ).";\n";

                        $fh = fopen($dbConfFile, 'w+');
                        if (!$fh) {
                            $form->addError(
                                '',
                                Yii::t(
                                    'InstallModule.install',
                                    "Can not open file '{file}' in write mode!",
                                    ['{file}' => $dbConfFile]
                                )
                            );
                        } else {
                            if (fwrite($fh, $dbConfString) && fclose($fh)) {
                                $this->session['InstallForm'] = array_merge(
                                    $this->session['InstallForm'],
                                    [
                                        'dbSettings' => $form->attributes,
                                        'dbSettingsStep' => true,
                                        'dbSettingsFile' => true,
                                    ]
                                );

                                $this->_setSession();

                                $this->redirect(['/install/default/dbsettings']);
                            } else {
                                $form->addError(
                                    '',
                                    Yii::t(
                                        'InstallModule.install',
                                        "There was an error writing to file '{file}'!",
                                        ['{file}' => $dbConfFile]
                                    )
                                );
                            }
                        }
                    }

                } catch (Exception $e) {
                    $form->addError(
                        '',
                        Yii::t(
                            'InstallModule.install',
                            'Couldn\'t connect to DB!'
                        ).'<br />'.$connectionString.'<br />'.$e->getMessage()
                    );
                    Yii::log($e->__toString(), CLogger::LEVEL_ERROR);
                    Yii::log($e->getTraceAsString(), CLogger::LEVEL_ERROR);
                }
            }
        }

        $result = false;

        if (file_exists($dbConfFile) && is_writable($dbConfFile)) {
            $result = true;
        }

        $this->render(
            '_view',
            [
                'data' => [
                    'model' => $form,
                    'result' => $result,
                    'file' => $dbConfFile,
                ],
            ]
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

        $modules = Yii::app()->moduleManager->getModulesDisabled();
        // Не выводить модуль install
        unset($modules['install']);

        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $this->session['InstallForm'] = array_merge(
                $this->session['InstallForm'],
                [
                    'moduleToInstall' => $_POST,
                    'modulesInstallStep' => true,
                ]
            );

            $this->_setSession();
            $this->_markFinished('modulesinstall');
            $this->redirect($this->createUrl('modulesinstall'));
        }

        if ((isset($this->session['InstallForm']['moduleToInstall'])) && ($this->session['InstallForm']['modulesInstallStep'] === true) && ($_POST = $this->session['InstallForm']['moduleToInstall'])) {

            $this->session['InstallForm'] = array_merge(
                $this->session['InstallForm'],
                [
                    'moduleToInstall' => $_POST,
                    'modulesInstallStep' => false,
                ]
            );
            $this->_setSession();
            $modulesByName = $toInstall = [];

            foreach ($modules as &$m) {
                $modulesByName[$m->id] = $m;
                if ($m->getIsNoDisable() || (isset($_POST['module_'.$m->id]) && $_POST['module_'.$m->id])) {
                    $toInstall[$m->id] = $m;
                }
            }
            unset($m);

            foreach ($toInstall as $m) {
                $deps = $m->getDependencies();
                if (!empty($deps)) {
                    foreach ($deps as $dep) {
                        if (!isset($toInstall[$dep])) {
                            Yii::app()->getUser()->setFlash(
                                yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                                Yii::t(
                                    'InstallModule.install',
                                    'Module "{module}" depends on the module "{dep}", which is not activated.',
                                    [
                                        '{module}' => $m->name,
                                        '{dep}' => isset($modulesByName[$dep]) ? $modulesByName[$dep]->name : $dep,
                                    ]
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

                Yii::app()->configManager->flushDump();

                $files = glob(Yii::app()->moduleManager->getModulesConfig()."*.php");
                foreach ($files as $file) {
                    $name = pathinfo($file, PATHINFO_FILENAME);
                    if ($name == 'yupe' || $name == 'install') {
                        continue;
                    }

                    $fileModule = Yii::app()->moduleManager->getModulesConfigDefault($name);
                    $fileConfig = Yii::app()->moduleManager->getModulesConfig($name);
                    $fileConfigBack = Yii::app()->moduleManager->getModulesConfigBack($name);

                    if ($name != \yupe\components\ModuleManager::CORE_MODULE && ((!(@is_file($fileModule) && @md5_file(
                                        $fileModule
                                    ) == @md5_file(
                                        $fileConfig
                                    )) && !@copy($fileConfig, $fileConfigBack)) || !@unlink($fileConfig))
                    ) {
                        $error = true;
                        Yii::app()->getUser()->setFlash(
                            yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                            Yii::t(
                                'InstallModule.install',
                                'An error occurred during the installation of modules - copying the file to a folder modulesBack with error!'
                            )
                        );
                        break;
                    }
                }
            }

            // Продолжаем установку модулей
            if (!$error) {
                return $this->render('begininstall', ['modules' => $toInstall]);
            }
        }

        $this->render(
            '_view',
            [
                'data' => [
                    'modules' => $modules,
                ],
            ]
        );
    }

    /**
     * Запись в "веб-лог" на странице:
     *
     * @param class $module - клас модуля
     * @param string $msg - сообщение
     * @param string $category - тип сообщения
     *
     * @return void вывод html
     */
    private function _logMessage($module, $msg, $category = 'notice')
    {
        $color = [
            'warning' => 'FF9600',
            'error' => 'FF0000',
        ];

        $msg = CHtml::tag("b", [], $module->name.": ").$msg;
        if (isset($color[$category])) {
            $msg = CHtml::openTag("span", ['style' => ('color: #'.$color[$category])]).$msg.CHtml::closeTag(
                    "span"
                );
        }
        echo $msg."<br />";
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
        $modules = Yii::app()->moduleManager->getModulesDisabled();

        if (empty($name) || !isset($modules[$name])) {
            throw new CHttpException(
                404, Yii::t(
                'InstallModule.install',
                'The module {name} not found!',
                ['{name}' => $name]
            )
            );
        }

        ob_start();
        ob_implicit_flush(false);

        $module = $modules[$name];

        $this->_logMessage($module, Yii::t('InstallModule.install', 'Updating module\'s tables to current state!'));

        try {
            $module->getInstall();
            $this->_logMessage($module, Yii::t('InstallModule.install', 'Installed!'));
            echo CJSON::encode(['installed' => [$module->getId()], 'log' => ob_get_clean()]);
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
                    [
                        'createUser' => $model->attributes,
                        'createUserStep' => false,
                    ]
                );
                $this->_markFinished('createuser');
                $this->_setSession();
                $this->redirect(['/install/default/sitesettings']);
            }
        }

        if (($data = Yii::app()->getRequest()->getPost('InstallForm')) !== null) {
            // Сбрасываем сессию текущего пользователя, может поменяться id
            Yii::app()->getUser()->clearStates();

            $model->setAttributes($data);

            if ($model->validate()) {

                $user = new User();

                $user->deleteAll();

                $user->setAttributes(
                    [
                        'nick_name' => $model->userName,
                        'email' => $model->userEmail,
                        'gender' => User::GENDER_THING,
                        'access_level' => User::ACCESS_LEVEL_ADMIN,
                        'status' => User::STATUS_ACTIVE,
                        'email_confirm' => User::EMAIL_CONFIRM_YES,
                        'hash' => Yii::app()->userManager->hasher->hashPassword(
                            $model->userPassword
                        ),
                        'birth_date' => null,
                    ]
                );

                if ($user->save()) {

                    //@TODO заменить на обработку через событие
                    if (Yii::app()->hasModule('rbac')) {
                        Yii::import('application.modules.rbac.models.*');
                        $assign = new AuthAssignment();
                        $assign->itemname = AuthItem::ROLE_ADMIN;
                        $assign->userid = $user->id;
                        $assign->save();
                    }

                    $login = new LoginForm();
                    $login->email = $model->userEmail;
                    $login->password = $model->userPassword;

                    Yii::app()->authenticationManager->login($login, Yii::app()->user, Yii::app()->request);

                    Yii::app()->getUser()->setFlash(
                        yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t('InstallModule.install', 'The administrator has successfully created!')
                    );

                    $this->session['InstallForm'] = array_merge(
                        $this->session['InstallForm'],
                        [
                            'createUser' => $model->attributes,
                            'createUserStep' => true,
                        ]
                    );

                    $this->_setSession();

                    $this->redirect(['/install/default/createuser']);
                } else {
                    $model->addErrors($user->getErrors());
                }
            }
        }
        $this->render(
            '_view',
            [
                'data' => [
                    'model' => $model,
                ],
            ]
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
                    [
                        'siteSettings' => $model->attributes,
                        'siteSettingsStep' => false,
                    ]
                );
                $this->_markFinished('sitesettings');
                $this->_setSession();
                $this->redirect(['/install/default/finish']);
            }
        }

        if ((Yii::app()->getRequest()->getIsPostRequest()) && (isset($_POST['InstallForm']))) {
            $model->setAttributes($_POST['InstallForm']);

            if ($model->validate()) {
                $transaction = Yii::app()->getDb()->beginTransaction();

                try {
                    Settings::model()->deleteAll();

                    $user = User::model()->admin()->findAll();

                    foreach ([
                                 'siteDescription',
                                 'siteName',
                                 'siteKeyWords',
                                 'email',
                                 'theme',
                                 'backendTheme',
                             ] as $param) {
                        $settings = new Settings();
                        $model->email = $model->siteEmail;

                        $settings->setAttributes(
                            [
                                'module_id' => 'yupe',
                                'param_name' => $param,
                                'param_value' => $model->$param,
                                'user_id' => $user[0]->id,
                            ]
                        );

                        if ($settings->save()) {
                            continue;
                        } else {
                            throw new CDbException(print_r($settings->getErrors(), true));
                        }
                    }

                    foreach (['defaultLanguage', 'defaultBackendLanguage'] as $param) {
                        $settings = new Settings();
                        $settings->setAttributes(
                            [
                                'module_id' => 'yupe',
                                'param_name' => $param,
                                'param_value' => Yii::app()->getLanguage(),
                                'user_id' => $user[0]->id,
                            ]
                        );
                        if ($settings->save()) {
                            continue;
                        } else {
                            throw new CDbException(print_r($settings->getErrors(), true));
                        }
                    }

                    $transaction->commit();

                    Yii::app()->getUser()->setFlash(
                        yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t('InstallModule.install', 'Site settings saved successfully!')
                    );

                    // попробуем создать каталог assets
                    $assetsPath = dirname(
                            Yii::app()->getRequest()->getScriptFile()
                        ).'/'.CAssetManager::DEFAULT_BASEPATH;

                    if (!is_dir($assetsPath)) {
                        @mkdir($assetsPath);
                    }

                    $this->session['InstallForm'] = array_merge(
                        $this->session['InstallForm'],
                        [
                            'siteSettings' => $model->attributes,
                            'siteSettingsStep' => true,
                        ]
                    );
                    $this->_setSession();
                    $this->redirect(['/install/default/finish']);
                } catch (CDbException $e) {
                    $transaction->rollback();

                    Yii::app()->getUser()->setFlash(
                        yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                        $e->__toString()
                    );

                    Yii::log($e->__toString(), CLogger::LEVEL_ERROR);

                    $this->redirect(['/install/default/sitesettings/']);
                }
            }
        } else {
            $model->siteEmail = $model->emailName;
        }
        $this->render(
            '_view',
            [
                'data' => [
                    'model' => $model,
                    'themes' => $this->yupe->getThemes(),
                    'backendThemes' => $this->yupe->getThemes(true),
                ],
            ]
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
            Yii::app()->getModule('install')->getDeActivate();
            Yii::app()->getUser()->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t(
                    'InstallModule.install',
                    "The module {name} is disabled!",
                    [
                        '{name}' => 'install',
                    ]
                )
            );
        } catch (Exception $e) {
            Yii::app()->getUser()->setFlash(
                yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                $e->getMessage()
            );
        }

        $this->render('_view');
    }
}
