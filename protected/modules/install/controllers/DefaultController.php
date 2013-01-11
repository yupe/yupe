<?php

class DefaultController extends YBackController
{
    public $stepName;

    public function filters()
    {
        return array();
    }

    public function init()
    {
        parent::init();

        $this->setPageTitle(Yii::t('InstallModule.install', 'Установка Юпи!'));

        $this->layout = 'application.modules.install.views.layouts.main';
    }

    protected function beforeAction($action)
    {
        if ($this->yupe->cache)
            Yii::app()->cache->flush();

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $this->stepName = Yii::t('InstallModule.install', 'Шаг 1 из 8 : "Приветствие!"');

        $this->render('index');
    }

    public function actionEnvironment()
    {
        $this->stepName = Yii::t('InstallModule.install', 'Шаг 2 из 8 : "Проверка окружения!"');

        $webRoot  = Yii::getPathOfAlias('webroot');
        $dp       = DIRECTORY_SEPARATOR;

        $requirements = array(
            array(
                Yii::t('InstallModule.install', 'Папка assets'),
                $this->checkWritable($webRoot . '/assets/'),
                Yii::t('InstallModule.install', 'Необходимо установить права записи на папку {folder} assets', array(
                    '{folder}' => $webRoot . $dp,
                )),
            ),
            array(
                Yii::t('InstallModule.install', 'Папка runtime'),
                $this->checkWritable($webRoot . '/protected/runtime/'),
                Yii::t('InstallModule.install', 'Необходимо установить права записи на папку {folder}', array(
                    '{folder}' => $webRoot . $dp . 'protected' . $dp . 'runtime',
                )),
            ),
            array(
                Yii::t('InstallModule.install', 'Папка uploads'),
                $this->checkWritable($webRoot . '/uploads/'),
                Yii::t('InstallModule.install', 'Необходимо установить права записи на папку {folder}', array(
                    '{folder}' => $webRoot . $dp . 'uploads',
                )),
            ),
            array(
                Yii::t('InstallModule.install', 'Папка modules'),
                $this->checkWritable($webRoot . '/protected/config/modules/'),
                Yii::t('InstallModule.install', 'Необходимо установить права записи на папку {folder}', array(
                    '{folder}' => $webRoot . $dp . 'protected' . $dp . 'config' . $dp . 'modules',
                )),
            ),
            array(
                Yii::t('InstallModule.install', 'Папка modulesBack'),
                $this->checkWritable($webRoot . '/protected/config/modulesBack/'),
                Yii::t('InstallModule.install', 'Необходимо установить права записи на папку {folder}', array(
                    '{folder}' => $webRoot . $dp . 'protected' . $dp . 'config' . $dp . 'modulesBack',
                )),
            ),
            array(
                Yii::t('InstallModule.install', 'Файл db.php'),
                $this->checkConfigFileWritable($webRoot . '/protected/config/db.back.php', $webRoot . '/protected/config/db.php'),
                Yii::t('InstallModule.install', 'Необходимо скопировать {file} и дать ему права на запись', array(
                    '{file}' => $webRoot . $dp . 'protected' . $dp . 'config' . $dp . 'db.back.php в ' . $webRoot . $dp . 'protected' . $dp . 'config' . $dp.'db.php',
                )),
            ),
            array(
                Yii::t('InstallModule.install', 'Активация ядра Юпи!'),
                $this->checkYupeActivate(),
                Yii::t('InstallModule.install', 'При запуске ядра произошли ошибки, пожалуйста, проверьте права доступа на все необходимые файлы и каталоги (см. ошибки выше)'),
            ),
        );

        $result = true;

        foreach ($requirements as $i => $requirement) {
            (!$requirement[1])
                ? $result = false
                : $requirements[$i][2] = Yii::t('InstallModule.install', 'Все хорошо!');
        }

        $this->render('environment', array(
            'requirements' => $requirements,
            'result'       => $result,
        ));
    }

    private function checkWritable($path)
    {
        return is_writable($path) || @chmod($path, 0777) && is_writable($path);
    }

    private function checkConfigFileWritable($pathOld, $pathNew)
    {
        return is_writable($pathNew) || @copy($pathOld, $pathNew) && is_writable($pathNew);
    }

    private function checkYupeActivate()
    {
        try {
            return Yii::app()->getModule('yupe')->activate;
        } catch(Exception $e) {
            return ($e->getCode() == 304) ? true : false;
        }
    }

    public function actionRequirements()
    {
        $this->stepName = Yii::t('InstallModule.install', 'Шаг 3 из 8 : "Проверка системных требований"');

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
                '' === $message=$this->checkServerVar(),
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
                false,
                extension_loaded('pdo'),
                Yii::t('InstallModule.install', 'Все <a href="http://www.yiiframework.com/doc/api/#system.db">DB-классы</a>'),
                '',
            ),
            array(
                Yii::t('InstallModule.install', 'Расширение PDO SQLite'),
                false,
                extension_loaded('pdo_sqlite'),
                Yii::t('InstallModule.install', 'Все <a href="http://www.yiiframework.com/doc/api/#system.db">DB-классы</a>'),
                Yii::t('InstallModule.install', 'Требуется для работы с БД SQLite.'),
            ),
            array(
                Yii::t('InstallModule.install', 'Расширение PDO MySQL'),
                false,
                extension_loaded('pdo_mysql'),
                Yii::t('InstallModule.install', 'Все <a href="http://www.yiiframework.com/doc/api/#system.db">DB-классы</a>'),
                Yii::t('InstallModule.install', 'Требуется для работы с БД MySQL.'),
            ),
            array(
                Yii::t('InstallModule.install', 'PDO PostgreSQL extension'),
                false,
                extension_loaded('pdo_pgsql'),
                Yii::t('InstallModule.install', 'Все <a href="http://www.yiiframework.com/doc/api/#system.db">DB-классы</a>'),
                Yii::t('InstallModule.install', 'Необходимо если вы используете PostgreSQL.'),
            ),
            array(
                Yii::t('InstallModule.install', 'Расширение PDO PostgreSQL'),
                false,
                extension_loaded('pdo_pgsql'),
                Yii::t('InstallModule.install', 'Все <a href="http://www.yiiframework.com/doc/api/#system.db">DB-классы</a>'),
                Yii::t('InstallModule.install', 'Требуется для работы с БД PostgreSQL.')),
            array(
                Yii::t('InstallModule.install', 'Расширение PDO Oracle'),
                false,
                extension_loaded('pdo_oci'),
                Yii::t('InstallModule.install', 'Все <a href="http://www.yiiframework.com/doc/api/#system.db">DB-классы</a>'),
                Yii::t('InstallModule.install', 'Требуется для работы с БД Oracle.')),
            array(
                Yii::t('InstallModule.install', 'Расширение PDO MSSQL (pdo_mssql)'),
                false,
                extension_loaded('pdo_mssql'),
                Yii::t('InstallModule.install', 'Все <a href="http://www.yiiframework.com/doc/api/#system.db">DB-классы</a>'),
                Yii::t('InstallModule.install', 'Требуется для работы с БД MSSQL при использовании из MS Windows.')),
            array(
                Yii::t('InstallModule.install', 'Расширение PDO MSSQL (pdo_dblib)'),
                false,
                extension_loaded('pdo_dblib'),
                Yii::t('InstallModule.install', 'Все <a href="http://www.yiiframework.com/doc/api/#system.db">DB-классы</a>'),
                Yii::t('InstallModule.install', 'Требуется для работы с БД MSSQL при использовании из GNU/Linux или UNIX.')),
            array(
                Yii::t('InstallModule.install', 'Расширение PDO MSSQL (<a href="http://sqlsrvphp.codeplex.com/">pdo_sqlsrv</a>)'),
                false,
                extension_loaded('pdo_sqlsrv'),
                Yii::t('InstallModule.install', 'Все <a href="http://www.yiiframework.com/doc/api/#system.db">DB-классы</a>'),
                Yii::t('InstallModule.install', 'Требуется для работы с БД MSSQL при использовании драйвера от Microsoft')),
            array(
                Yii::t('InstallModule.install', 'Расширение Memcache'),
                false,
                extension_loaded("memcache") || extension_loaded("memcached"),
                '<a href="http://www.yiiframework.com/doc/api/CMemCache">CMemCache</a>',
                extension_loaded("memcached") ? Yii::t('InstallModule.install', 'Чтобы использовать memcached установите значение свойства <a href="http://www.yiiframework.com/doc/api/CMemCache#useMemcached-detail">CMemCache::useMemcached</a> равным <code>true</code>.') : '',
            ),
            array(
                Yii::t('InstallModule.install', 'Расширение APC'),
                false,
                extension_loaded("apc"),
                '<a href="http://www.yiiframework.com/doc/api/CApcCache">CApcCache</a>',
                Yii::t('InstallModule.install', 'Акселератор PHP — программа, ускоряющая исполнение сценариев PHP интерпретатором путём кэширования их байткода. <b>Необязательно</b>.'),
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
                Yii::t('InstallModule.install', 'Расширение GD<br />с поддержкой FreeType<br />или ImageMagick<br />с поддержкой PNG'),
                false,
                '' === $message=$this->checkCaptchaSupport(),
                '<a href="http://www.yiiframework.com/doc/api/CCaptchaAction">CCaptchaAction</a>',
                $message),
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
        );

        $result = true;

        foreach ($requirements as $i => $requirement)
        {
            if ($requirement[1] && !$requirement[2])
                $result = false;
        }

        $this->render('requirements', array(
            'requirements' => $requirements,
            'result'       => $result,
        ));
    }

    private function checkServerVar()
    {
        $vars = array('HTTP_HOST', 'SERVER_NAME', 'SERVER_PORT', 'SCRIPT_NAME', 'SCRIPT_FILENAME', 'PHP_SELF', 'HTTP_ACCEPT', 'HTTP_USER_AGENT');
        $missing = array();
        foreach ($vars as $var)
        {
            if (!isset($_SERVER[$var]))
                $missing[] = $var;
        }
        if (!empty($missing))
            return Yii::t('InstallModule.install', 'Переменная $_SERVER не содержит {vars}.', array('{vars}' => implode(', ', $missing)));
        // @TODO У меня следующие значения:
        // C:\Webserver\apache\htdocs\public_html\yupe.local\index.php
        // C:\Webserver\apache\htdocs\public_html\yupe.local\protected\modules\install\controllers\DefaultController.php
        // if (realpath($_SERVER["SCRIPT_FILENAME"]) !== realpath(__FILE__))
            // return Yii::t('InstallModule.install', 'Переменная $_SERVER["SCRIPT_FILENAME"] должна соответствовать пути к файлу входного скрипта.');
        if (!isset($_SERVER["REQUEST_URI"]) && isset($_SERVER["QUERY_STRING"]))
            return Yii::t('InstallModule.install', 'Должна существовать хотя бы одна из серверных переменных: $_SERVER["REQUEST_URI"] или $_SERVER["QUERY_STRING"].');
        if (!isset($_SERVER["PATH_INFO"]) && strpos($_SERVER["PHP_SELF"], $_SERVER["SCRIPT_NAME"]) !== 0)
            return Yii::t('InstallModule.install', 'Не удалось получить информацию о пути. Пожалуйста, проверьте, содержится ли корректное значение в переменной $_SERVER["PATH_INFO"] (или $_SERVER["PHP_SELF"] и $_SERVER["SCRIPT_NAME"]).');
        return '';
    }

    private function checkCaptchaSupport()
    {
        if (extension_loaded('imagick'))
        {
            $imagick = new Imagick();
            $imagickFormats = $imagick->queryFormats('PNG');
        }
        if (extension_loaded('gd'))
            $gdInfo = gd_info();
        if (isset($imagickFormats) && in_array('PNG', $imagickFormats))
            return '';
        else if (isset($gdInfo))
        {
            if ($gdInfo['FreeType Support'])
                return '';
            return Yii::t('InstallModule.install', 'Расширение GD установлено<br />без поддержки FreeType');
        }
        return Yii::t('InstallModule.install', 'Расширение GD или ImageMagick не установлены');
    }

    public function actionDbsettings()
    {
        $this->stepName = Yii::t('InstallModule.install', 'Шаг 4 из 8 : "Соединение с базой данных"');

        $dbConfFile = Yii::app()->basePath . '/config/' . 'db.php';

        $form = new DbSettingsForm;

        if (Yii::app()->request->isPostRequest)
        {
            $form->setAttributes($_POST['DbSettingsForm']);

            if ($form->validate())
            {
                try
                {
                    $socket = ($form->socket == '') ? '' : 'unix_socket=' . $form->socket . ';';
                    $port   = ($form->port == '') ? '' : 'port=' . $form->port . ';';

                    $connectionString = "mysql:host={$form->host};{$port}{$socket}dbname={$form->dbName}";

                    $connection = new CDbConnection($connectionString, $form->user, $form->password);
                    $connection->connectionString = $connectionString;
                    $connection->username         = $form->user;
                    $connection->password         = $form->password;
                    $connection->emulatePrepare   = true;
                    $connection->charset          = 'utf8';
                    $connection->active           = true;
                    $connection->tablePrefix      = $form->tablePrefix . '_';

                    Yii::app()->setComponent('db', $connection);

                    $dbParams = array(
                        'class'                 => 'CDbConnection',
                        'connectionString'      => $connectionString,
                        'username'              => $form->user,
                        'password'              => $form->password,
                        'emulatePrepare'        => true,
                        'charset'               => 'utf8',
                        'enableParamLogging'    => 0,
                        'enableProfiling'       => 0,
                        'schemaCachingDuration' => 108000,
                        'tablePrefix'           => $form->tablePrefix . '_',
                    );

                    $dbConfString = "<?php\n return " . var_export($dbParams, true) . ";\n?>";

                    $fh = fopen($dbConfFile, 'w+');
                    if (!$fh)
                        $form->addError('', Yii::t('InstallModule.install', "Не могу открыть файл '{file}' для записии!", array('{file}' => $dbConfFile)));
                    else
                    {
                        if (fwrite($fh, $dbConfString) && fclose($fh))
                            $this->redirect(array('/install/default/modulesinstall'));
                        else
                            $form->addError('', Yii::t('InstallModule.install', "Произошла ошибка записи в файл '{file}'!", array('{file}' => $dbConfFile)));
                    }
                }
                catch (Exception $e)
                {
                    $form->addError('', Yii::t('InstallModule.install', 'С указанными параметрами подключение к БД не удалось выполнить! ' . $e->__toString()));
                    Yii::log($e->getTraceAsString(), CLogger::LEVEL_ERROR);
                }
            }
        }

        $result = false;

        if (file_exists($dbConfFile) && is_writable($dbConfFile))
            $result = true;

        $this->render('dbsettings', array(
            'model'     => $form,
            'result'    => $result,
            'file'      => $dbConfFile,
        ));
    }

    public function actionModulesinstall()
    {
        $this->stepName = Yii::t('InstallModule.install', 'Шаг 5 из 8 : "Установка модулей"');
        $error = false;

        $modules = $this->yupe->getModulesDisabled();
        // Не выводить модуль install
        unset($modules['install']);

        if (Yii::app()->request->isPostRequest)
        {
            $modulesByName = $toInstall = array();

            foreach ($modules as &$m)
            {
                $modulesByName[$m->id] = $m;
                if ($m->isNoDisable || (isset($_POST['module_' . $m->id]) && $_POST['module_' . $m->id]))
                    $toInstall[$m->id] = $m;
            }
            unset($m);

            // Проверим зависимости
            $deps = array();
            foreach ($toInstall as $m)
            {
                if ($m->dependencies !== array())
                {
                    foreach ($m->dependencies as $dep)
                    {
                        if (!isset($toInstall[$dep]))
                        {
                            Yii::app()->user->setFlash(
                                YFlashMessages::ERROR_MESSAGE,
                                Yii::t('InstallModule.install', 'Модуль "{module}" зависит от модуля "{dep}", который не активирован.', array(
                                    '{module}' => $m->name,
                                    '{dep}'    => isset($modulesByName[$dep]) ? $modulesByName[$dep]->name : $dep
                                ))
                            );
                            $error = true;
                            break;
                        }
                    }
                }
            }
            if (!$error)
            {
                // Переносим конфигурационные файлы не устанавливаемых модулей в back-папку
                $files = glob($this->yupe->getModulesConfig() . "*.php");
                foreach ($files as $file)
                {
                    $name = preg_replace('#^.*/([^\.]*)\.php$#', '$1', $file);

                    if ($name == 'yupe')
                        continue;

                    $fileModule     = $this->yupe->getModulesConfigDefault($name);
                    $fileConfig     = $this->yupe->getModulesConfig($name);
                    $fileConfigBack = $this->yupe->getModulesConfigBack($name);

                    if ($name != 'yupe' && ((
                                !(@is_file($fileModule) && @md5_file($fileModule) == @md5_file($fileConfig)) &&
                                !@copy($fileConfig, $fileConfigBack)
                            ) || !@unlink($fileConfig)
                        )
                    )
                    {
                        $error = true;
                        Yii::app()->user->setFlash(
                            YFlashMessages::ERROR_MESSAGE,
                            Yii::t('InstallModule.install', 'Произошла ошибка установки модулей - ошибка копирования файла в папку modulesBack!')
                        );
                        break;
                    }
                }
            }

            // Продолжаем установку модулей
            if (!$error)
                return $this->render('begininstall', array('modules' => $toInstall));
        }
        $this->render('modulesinstall', array('modules' => $modules));
    }

    private function logMessage($module, $msg, $category = 'notice')
    {
        $color = array(
            'warning' => 'FF9600',
            'error'   => 'FF0000',
        );

        $msg = CHtml::tag("b", array(), $module->name . ": ") . $msg;
        if (isset($color[$category]))
            $msg = CHtml::openTag("span", array('style' => ('color: #' . $color[$category]))) . $msg . CHtml::closeTag("span");
        echo $msg . "<br />";
    }

    public function actionModuleinstall($name = null)
    {
        $modules = $this->yupe->getModulesDisabled();

        if (empty($name) || !isset($modules[$name]))
        {
            throw new CHttpException(404, Yii::t('InstallModule.install', 'Указанный модуль {name} не найден!', array('{name}' => $name)));
            Yii::app()->end();
        }

        ob_start();
        ob_implicit_flush(false);

        $module = $modules[$name];

        $this->logMessage($module, Yii::t('InstallModule.install', 'Обновляем базу модуля до актуального состояния!'));

        try {
            $installed = $module->install;

            $this->logMessage($module, Yii::t('InstallModule.install', 'Модуль установлен!'));
            echo CJSON::encode(array('installed' => array($module->id), 'log' => ob_get_clean()));
        } catch(Exception $e) {
            $this->logMessage($module, $e->getMessage(), "error");
            echo ob_get_clean();
        }
        Yii::app()->end();
    }

    public function actionCreateuser()
    {
        $this->stepName = Yii::t('InstallModule.install', 'Шаг 6 из 8 : "Создание учетной записи администратора"');

        $model = new CreateUserForm;

        if (Yii::app()->request->isPostRequest && isset($_POST['CreateUserForm']))
        {
            // Сбрасываем сессию текущего пользователя, может поменяться id
            Yii::app()->user->clearStates();

            $model->setAttributes($_POST['CreateUserForm']);

            if ($model->validate())
            {
                $user = new User;

                $user->deleteAll();

                $salt = $user->generateSalt();

                $user->setAttributes(array(
                    'nick_name'         => $model->userName,
                    'email'             => $model->email,
                    'salt'              => $salt,
                    'password'          => User::model()->hashPassword($model->password, $salt),
                    'registration_date' => new CDbExpression('NOW()'),
                    'registration_ip'   => Yii::app()->request->userHostAddress,
                    'activation_ip'     => Yii::app()->request->userHostAddress,
                    'access_level'      => User::ACCESS_LEVEL_ADMIN,
                    'status'            => User::STATUS_ACTIVE,
                    'email_confirm'     => User::EMAIL_CONFIRM_YES,
                ));

                if ($user->save())
                {
                    $login = new LoginForm;
                    $login->email    = $model->email;
                    $login->password = $model->password;
                    $login->authenticate();

                    Yii::app()->user->setFlash(
                        YFlashMessages::NOTICE_MESSAGE,
                        Yii::t('InstallModule.install', 'Администратор успешно создан!')
                    );

                    $this->redirect(array('/install/default/sitesettings/'));
                }
            }
        }
        $this->render('createuser', array('model' => $model));
    }

    public function actionSitesettings()
    {
        $this->stepName = Yii::t('InstallModule.install', 'Шаг 7 из 8 : "Настройки проекта"');

        $model = new SiteSettingsForm;

        if (Yii::app()->request->isPostRequest)
        {
            $model->setAttributes($_POST['SiteSettingsForm']);

            if ($model->validate())
            {
                $transaction = Yii::app()->db->beginTransaction();

                try {
                    Settings::model()->deleteAll();

                    $user = User::model()->admin()->findAll();

                    foreach (array('siteDescription', 'siteName', 'siteKeyWords', 'email') as $param)
                    {
                        $settings = new Settings;

                        $settings->setAttributes(array(
                            'module_id'   => 'yupe',
                            'param_name'  => $param,
                            'param_value' => $model->$param,
                            'user_id'     => $user[0]->id,
                        ));

                        if ($settings->save())
                            continue;
                        else
                            throw new CDbException(print_r($settings->getErrors(), true));
                    }

                    $transaction->commit();

                    Yii::app()->user->setFlash(
                        YFlashMessages::NOTICE_MESSAGE,
                        Yii::t('InstallModule.install', 'Настройки сайта успешно сохранены!')
                    );

                    // попробуем создать каталог assets
                    $assetsPath = dirname(Yii::app()->request->getScriptFile()) . '/' . CAssetManager::DEFAULT_BASEPATH;

                    if (!is_dir($assetsPath))
                        @mkdir ($assetsPath);

                    $this->redirect(array('/install/default/finish/'));
                } catch (CDbException $e) {
                    $transaction->rollback();

                    Yii::app()->user->setFlash(
                        YFlashMessages::ERROR_MESSAGE,
                        $e->__toString()
                    );

                    Yii::log($e->__toString(),  CLogger::LEVEL_ERROR);

                    $this->redirect(array('/install/default/sitesettings/'));
                }
            }
        }
        else
            $model->email = $model->emailName;
        $this->render('sitesettings', array('model' => $model));
    }

    public function actionFinish()
    {
        $this->stepName = Yii::t('InstallModule.install', 'Шаг 8 из 8 : "Окончание установки"');

        try {
            Yii::app()->getModule('install')->activate;
            Yii::app()->user->setFlash(
                YFlashMessages::NOTICE_MESSAGE,
                Yii::t('InstallModule.install', "Модуль install отключен!")
            );
        } catch(Exception $e) {
            Yii::app()->user->setFlash(
                YFlashMessages::ERROR_MESSAGE,
                $e->getMessage()
            );
        }

        $this->render('finish');
    }
}
