<?php
class DefaultController extends Controller
{
    public $layout = 'application.modules.install.views.layouts.main';
    public $stepName;
    private $alreadyInstalledFlag;

    public function init()
    {
        $this->alreadyInstalledFlag = Yii::app()->basePath . '/config/' . '.ai';
    }

    protected function beforeAction($action)
    {
        // Проверяем установку сайта       
        if (file_exists($this->alreadyInstalledFlag))
            throw new CHttpException(404, Yii::t('install', 'Страница не найдена!'));

        Yii::app()->cache->flush();

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $this->stepName = Yii::t('install', 'Шаг 1 из 6 : "Приветствие!"');

        $this->render('index');
    }

    public function actionRequirements()
    {
        $this->stepName = Yii::t('install', 'Шаг 2 из 6 : "Проверка системных требований"');

        $requirements = array(
            array(
                Yii::t('install', 'PHP version'),
                true,
                version_compare(PHP_VERSION, "5.1.0", ">="),
                '<a href="http://www.yiiframework.com">Yii Framework</a>',
                Yii::t('install', 'PHP 5.1 или версия выше.'),
            ),
            array(
                Yii::t('install', 'Reflection extension'),
                true,
                class_exists('Reflection', false),
                '<a href="http://www.yiiframework.com">Yii Framework</a>',
                '',
            ),
            array(
                Yii::t('install', 'PCRE extension'),
                true,
                extension_loaded("pcre"),
                '<a href="http://www.yiiframework.com">Yii Framework</a>',
                '',
            ),
            array(
                Yii::t('install', 'SPL extension'),
                true,
                extension_loaded("SPL"),
                '<a href="http://www.yiiframework.com">Yii Framework</a>',
                '',
            ),
            array(
                Yii::t('install', 'DOM extension'),
                false,
                class_exists("DOMDocument", false),
                '<a href="http://www.yiiframework.com/doc/api/CHtmlPurifier">CHtmlPurifier</a>,
                 <a href="http://www.yiiframework.com/doc/api/CWsdlGenerator">CWsdlGenerator</a>',
                '',
            ),
            array(
                Yii::t('install', 'PDO extension'),
                false,
                extension_loaded('pdo'),
                Yii::t('install', 'All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>'),
                '',
            ),
            array(
                Yii::t('install', 'PDO SQLite extension'),
                false,
                extension_loaded('pdo_sqlite'),
                Yii::t('install', 'All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>'),
                Yii::t('install', 'Необходимо если вы используете SQLite.'),
            ),
            array(
                Yii::t('install', 'PDO MySQL extension'),
                false,
                extension_loaded('pdo_mysql'),
                Yii::t('install', 'All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>'),
                Yii::t('install', 'Необходимо если вы используете MySQL.'),
            ),
            array(
                Yii::t('install', 'PDO PostgreSQL extension'),
                false,
                extension_loaded('pdo_pgsql'),
                Yii::t('install', 'All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>'),
                Yii::t('install', 'Необходимо если вы используете PostgreSQL.'),
            ),
            array(
                Yii::t('install', 'Memcache extension'),
                false,
                extension_loaded("memcache"),
                '<a href="http://www.yiiframework.com/doc/api/CMemCache">CMemCache</a>',
                Yii::t('install', 'Используется для кэширования, <b>необязательно</b>.'),
            ),
            array(
                Yii::t('install', 'APC extension'),
                false,
                extension_loaded("apc"),
                '<a href="http://www.yiiframework.com/doc/api/CApcCache">CApcCache</a>',
                Yii::t('install', 'Акселератор PHP — программа, ускоряющая исполнение сценариев PHP интерпретатором путём кэширования их байткода. <b>Необязательно</b>.'),
            ),
            array(
                Yii::t('install', 'Mcrypt extension'),
                false,
                extension_loaded("mcrypt"),
                '<a href="http://www.yiiframework.com/doc/api/CSecurityManager">CSecurityManager</a>',
                Yii::t('install', 'Необходимо для encrypt и decrypt методов.'),
            ),
            array(
                Yii::t('install', 'SOAP extension'),
                false,
                extension_loaded("soap"),
                '<a href="http://www.yiiframework.com/doc/api/CWebService">CWebService</a>,
                 <a href="http://www.yiiframework.com/doc/api/CWebServiceAction">CWebServiceAction</a>',
                Yii::t('install', '<b>Необязательно</b>.'),
            ),
        );

        $result = 1;

        foreach ($requirements as $i => $requirement)
        {
            if ($requirement[1] && !$requirement[2])
                $result = 0;
            else if ($result > 0 && !$requirement[1] && !$requirement[2])
                $result = -1;
            if ($requirement[4] === '')
                $requirements[$i][4] = '&nbsp;';
        }

        $this->render('requirements', array(
            'requirements' => $requirements,
            'result'       => $result,
        ));
    }

    public function actionDbsettings()
    {
        $this->stepName = Yii::t('install', 'Шаг 3 из 6 : "Соединение с базой данных"');

        $dbConfFile = Yii::app()->basePath . '/config/' . 'db.php';

        $sqlDataDir = $this->module->basePath . '/data/';
        $sqlDbDir = $sqlDataDir . 'db/';

        $sqlFile = $sqlDataDir . 'yupe.sql';
        $sqlDropFile = $sqlDataDir . 'yupe_drop.sql';

        $form = new DbSettingsForm;

        if (Yii::app()->request->isPostRequest)
        {
            $form->setAttributes($_POST['DbSettingsForm']);

            if ($form->validate())
            {
                try
                {
                    $socket = ($form->socket == '') ? '' : 'unix_socket=' . $form->socket . ';';
                    $port = ($form->port == '') ? '' : 'port=' . $form->port . ';';

                    $connectionString = "mysql:host={$form->host};{$port}{$socket}dbname={$form->dbName}";

                    $connection = new CDbConnection($connectionString, $form->user, $form->password);
                    $connection->connectionString = $connectionString;
                    $connection->username         = $form->user;
                    $connection->password         = $form->password;
                    $connection->emulatePrepare   = true;
                    $connection->charset          = 'utf8';
                    $connection->active           = true;
                    $connection->tablePrefix      = $form->tablePrefix;

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
                        'tablePrefix'           => $form->tablePrefix,
                    );

                    $dbConfString = "<?php\n return " . var_export($dbParams, true) . ";\n?>";

                    $fh = fopen($dbConfFile, 'w+');

                    if (!$fh)
                        $form->addError('', Yii::t('install', "Не могу открыть файл '{file}' для записии!", array('{file}' => $dbConfFile)));
                    else
                    {
                        //@TODO корректная обработка ошибок IO
                        fwrite($fh, $dbConfString);
                        fclose($fh);
                        @chmod($dbConfFile, 0666);

                        $transaction = Yii::app()->db->beginTransaction();

                        try
                        {
                            //@TODO проверяет наличие таблиц с заданным префиксом, требуется доработка
                            $tables = Yii::app()->db->schema->getTables();
                            foreach ($tables as $table)
                            {
                                if (strpos($table->name, $form->tablePrefix) === 0)
                                    $issetTable = true;
                            }

                            if (isset($issetTable))
                                $this->executeSql($sqlDropFile);

                            $this->executeSql($sqlFile);

                            // Установить .sql файлы модулей yupe
                            $sqlFiles = glob("{$sqlDbDir}*.sql");

                            if (is_array($sqlFiles))
                            {
                                foreach ($sqlFiles as $file)
                                    $this->executeSql($file);
                            }

                            $transaction->commit();

                            Yii::app()->user->setFlash(
                                YFlashMessages::NOTICE_MESSAGE,
                                Yii::t('install', 'База данных успешно заполнена!')
                            );

                            $this->redirect(array('/install/default/createuser/'));
                        }
                        catch (Exception $e)
                        {
                            $transaction->rollback();

                            Yii::app()->user->setFlash(
                                YFlashMessages::ERROR_MESSAGE,
                                Yii::t('install', 'При инициализации базы данных произошла ошибка!')
                            );
                            var_dump($e);
                            Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);

                            $this->redirect(array('/install/default/dbsettings/'));
                        }
                    }
                }
                catch (Exception $e)
                {
                    $form->addError('', Yii::t('install', 'С указанными параметрами подключение к БД не удалось выполнить!'));
                }
            }
        }

        $result = $sqlResult = false;

        if (file_exists($dbConfFile) && is_writable($dbConfFile))
            $result = true;

        if (file_exists($sqlFile) && is_readable($sqlFile))
            $sqlResult = true;

        $this->render('dbsettings', array(
            'model'     => $form,
            'sqlResult' => $sqlResult,
            'sqlFile'   => $sqlFile,
            'result'    => $result,
            'file'      => $dbConfFile,
        ));
    }

    public function actionCreateuser()
    {
        $this->stepName = Yii::t('install', 'Шаг 4 из 6 : "Создание учетной записи администратора"');

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
                    Yii::app()->user->setFlash(
                        YFlashMessages::NOTICE_MESSAGE,
                        Yii::t('install', 'Администратор успешно создан!')
                    );

                    $this->redirect(array('/install/default/sitesettings/'));
                }
            }
        }

        $this->render('createuser', array('model' => $model));
    }

    public function actionSitesettings()
    {
        $this->stepName = Yii::t('install', 'Шаг 5 из 6 : "Настройки проекта"');

        $model = new SiteSettingsForm;

        if (Yii::app()->request->isPostRequest)
        {
            $model->setAttributes($_POST['SiteSettingsForm']);

            if ($model->validate())
            {
                $transaction = Yii::app()->db->beginTransaction();

                try
                {
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
                        Yii::t('install', 'Настройки сайта успешно сохранены!')
                    );

                    // попробуем создать каталог assets
                    $assetsPath = dirname(Yii::app()->request->getScriptFile()) . '/' . CAssetManager::DEFAULT_BASEPATH;

                    if (!is_dir($assetsPath))
                        @mkdir ($assetsPath);

                    $this->redirect(array('/install/default/finish/'));
                }
                catch (CDbException $e)
                {
                    $transaction->rollback();

                    Yii::app()->user->setFlash(
                        YFlashMessages::ERROR_MESSAGE,
                        $e->getMessage()
                    );

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
        if (!@touch($this->alreadyInstalledFlag))
            Yii::app()->user->setFlash(
                YFlashMessages::WARNING_MESSAGE,
                Yii::t('install', "Не удалось создать файл {file}, для избежания повторной установки, пожалуйста, создайте его самостоятельно или отключите модуль 'Install' сразу после установки!", array('{file}' => $this->alreadyInstalledFlag))
            );

        $this->stepName = Yii::t('install', 'Шаг 6 из 6 : "Окончание установки"');

        $this->render('finish');
    }

    private function executeSql($sqlFile)
    {
        $sql = file_get_contents($sqlFile);
        $command = Yii::app()->db->createCommand($sql);

        return $command->execute();
    }
}
