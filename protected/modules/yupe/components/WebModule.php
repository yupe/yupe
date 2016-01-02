<?php
/**
 * WebModule - базовый класс для всех модулей Юпи!
 *
 * Все модули, разработанные для Юпи! должны наследовать этот класс.
 * Панель управления Юпи!, собираемая из модулей, использует определенные методы этого базового класса.
 *
 * @category YupeModule
 * @package  yupe.modules.yupe.components
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     http://yupe.ru
 *
 */
namespace yupe\components;

use CChainedCacheDependency;
use CDbException;
use CDirectoryCacheDependency;
use CException;
use CList;
use CLogger;
use TagsCache;
use yupe\widgets\YFlashMessages;
use Yii;
use CWebModule;
use Category;

use yupe\models\Settings;

/**
 * Class WebModule
 * @package yupe\components
 */
abstract class WebModule extends CWebModule
{
    /**
     *
     */
    const CHECK_ERROR = 'danger';
    /**
     *
     */
    const CHECK_NOTICE = 'warning';

    /**
     *
     */
    const CHOICE_YES = 1;
    /**
     *
     */
    const CHOICE_NO = 0;

    /**
     * @var integer категория для контента модуля
     * @since 0.6
     */
    public $mainCategory;

    /**
     * @var str каталог с документацией внутри модуля
     * @since 0.5.1
     */
    public $docPath = 'guide';

    /**
     * @var int порядок следования модуля в меню панели управления (сортировка)
     */
    public $adminMenuOrder = 0;
    /**
     * @var int некоторые компоненты Юпи! автоматически кэширует, если время жизни кэша не указано - берется это значение
     */
    public $coreCacheTime = 3600;

    /**
     * @var string - id редактора
     */
    public $editor = 'redactor';

    /**
     * @var null|string - класс редактора
     */
    protected $visualEditor = null;

    /**
     * @var array - массив редакторов
     */
    public $visualEditors = [
        'redactor' => [
            'class' => 'yupe\widgets\editors\Redactor',
        ],
    ];
    /**
     * @var bool | string
     *
     * Имя модели, которая является профилем пользователя для конкретного модуля
     *
     */
    public $profileModel = false;

    /**
     * @var int
     * @since 0.7
     *
     * Максимальный размер загружаемых файлов - 5 MB
     */
    public $maxSize = 5242880;

    /**
     * @var string
     * @since 0.7
     *
     * Разрешенные mime types файлов для загрузки
     *
     */
    public $mimeTypes = 'image/gif, image/jpeg, image/png, application/zip, application/rar';

    /**
     * @var string
     * @since 0.7
     *
     * Разрешенные расширения файлов для загрузки
     */

    public $allowedExtensions = 'gif, jpeg, png, jpg, zip, rar';

    /**
     * Путь к ресурсам модуля, например application.modules.yupe.views.assets
     * @var string
     */
    public $assetsPath;
    /**
     * @var
     */
    private $_assetsUrl;

    /**
     * @var array
     * @since 0.8
     *
     * Содержит массив виджетов для отображения на главной странице панели управления
     * Виджеты отображаются в порядке их перечисления
     */
    protected $panelWidgets = [];

    /**
     * @param array $widgets
     * @since 0.8
     */
    public function setPanelWidgets(array $widgets)
    {
        $this->panelWidgets = $widgets;
    }

    /**
     * @return array
     * @since 0.8
     *
     */
    public function getPanelWidgets()
    {
        return $this->panelWidgets;
    }

    /**
     * @return bool|string
     * @since 0.7
     */
    public function getProfileModel()
    {
        return $this->profileModel;
    }

    /**
     * @var array список категорий
     */
    public function getCategoryList()
    {
        return Category::model()->roots()->findAll();
    }

    /**
     * текущая версия модуля
     *
     * @return string
     */
    public function getVersion()
    {
        return '0.1';
    }

    /**
     * веб-сайт разработчика модуля или страничка самого модуля
     *
     * @return string
     */
    public function getUrl()
    {
        return 'http://yupe.ru';
    }

    /**
     * имя автора модуля
     *
     * @return string
     */
    public function getAuthor()
    {
        return Yii::t('YupeModule.yupe', 'Yupe community!');
    }

    /**
     * контактный email автора модуля
     *
     * @return string
     */
    public function getAuthorEmail()
    {
        return 'support@yupe.ru';
    }

    /**
     * ссылка которая будет отображена в панели управления
     * как правило, ведет на страничку для администрирования модуля
     *
     * @return string
     */
    public function getAdminPageLink()
    {
        return '/' . strtolower($this->id) . '/' . strtolower($this->defaultController) . '/index';
    }

    /**
     * ссылка которая будет отображена в панели управления
     * как правило, ведет на страничку для администрирования модуля
     *
     * @return string
     */
    public function getAdminPageLinkNormalize()
    {
        return is_array($this->adminPageLink) ? $this->adminPageLink : [$this->adminPageLink];
    }

    /**
     * если модуль должен добавить несколько ссылок в панель управления - укажите массив
     *
     * @return array
     *
     * @example
     *
     * public function getNavigation()
     * {
     *       return array(
     *           Yii::t('YupeModule.yupe','Blogs')     => '/blog/blogBackend/admin/',
     *           Yii::t('YupeModule.yupe','Posts')    => '/blog/postBackend/admin/',
     *           Yii::t('YupeModule.yupe','Members') => '/blog/BlogToUserBackend/admin/',
     *      );
     * }
     *
     */
    public function getNavigation()
    {
        return false;
    }

    /**
     * Расширенное меню модуля, формат такой же, как и у {@see getNavigation()}
     * @return array
     */
    public function getExtendedNavigation()
    {
        return [];
    }

    /**
     * Работоспособность модуля может зависеть от разных факторов: версия php, версия Yii, наличие определенных модулей и т.д.
     * В этом методе необходимо выполнить все проверки.
     *
     * @return array или false
     *
     * @example
     *   if (!$this->uploadPath)
     *        return array(
     *            'type' => WebModule::CHECK_ERROR,
     *            'message' => Yii::t('YupeModule.yupe', 'Please, set images uploading directory! {link}', array(
     *                '{link}' => CHtml::link(Yii::t('YupeModule.yupe', 'Change module settings'), array('/yupe/backend/modulesettings/', 'module' => $this->id))
     *            ))
     *        );
     *   Данные сообщения выводятся на главной странице панели управления
     *
     */
    public function checkSelf()
    {
        return true;
    }

    /**
     * каждый модуль должен принадлежать одной категории, именно по категориям делятся модули в панели управления
     *
     * @return string
     */
    public function getCategory()
    {
        return null;
    }

    /**
     * массив лейблов для параметров (свойств) модуля. Используется на странице настроек модуля в панели управления.
     *
     * @return array
     */
    public function getParamsLabels()
    {
        return [
            'adminMenuOrder' => Yii::t('YupeModule.yupe', 'Menu items order'),
            'coreCacheTime'  => Yii::t('YupeModule.yupe', 'Cache time')
        ];

    }


    /**
     * массив лейблов для параметров (свойств) модуля. Используется на странице настроек модуля в панели управления.
     *
     * @return array
     */
    public function getDefaultParamsLabels()
    {
        return [
            'adminMenuOrder' => Yii::t('YupeModule.yupe', 'Menu items order'),
            'coreCacheTime'  => Yii::t('YupeModule.yupe', 'Cache time')
        ];

    }

    /**
     * массив параметров модуля, которые можно редактировать через панель управления (GUI)
     *
     * @return array
     */
    public function getEditableParams()
    {
        return ['adminMenuOrder', 'coreCacheTime'];
    }

    /**
     * Массив правил валидации для модуля
     *
     * Пример использования возвращаемого массива:
     * <pre>
     * array(
     *     array('adminMenuOrder', 'required'),
     *     array('someEditableParam1, someEditableParam2', 'length', 'min'=>3, 'max'=>12),
     *     array('anotherEditableParam', 'compare', 'compareAttribute'=>'password2', 'on'=>'register'),
     * );
     * </pre>
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * Метод формирующий из массива "правил валидации для модуля" правила для указаного параметра
     *
     * @param $param Параметр для которого необходимо сформировать правила валидации
     * @return array Массив с правилами валидации для $param
     */
    public function getRulesForParam($param)
    {

        $rulesFromParam = new CList();
        foreach ($this->rules() as $rule) {
            $params = preg_split('/[\s,]+/', $rule[0], -1, PREG_SPLIT_NO_EMPTY);
            if (in_array($param, $params)) {
                $rule[0] = 'param_value';
                $rulesFromParam->add($rule);
            }
        }

        return $rulesFromParam->toArray();
    }

    /**
     * массив групп параметров модуля, для группировки параметров на странице настроек
     *
     * @return array
     */
    public function getEditableParamsGroups()
    {
        return [
            'main' => [
                'label' => Yii::t('YupeModule.yupe', 'Main module settings'),
                'items' => [
                    'adminMenuOrder',
                    'coreCacheTime'
                ]
            ],
        ];
    }

    /**
     * получение имен параметров из getEditableParams()
     *
     * @return array
     */
    public function getEditableParamsKey()
    {
        $keyParams = [];
        foreach ($this->getEditableParams() as $key => $value) {
            $keyParams[] = is_int($key) ? $value : $key;
        }

        return $keyParams;
    }

    /**
     * порядок следования модуля в меню панели управления (сортировка)
     *
     * @return int
     */
    public function getAdminMenuOrder()
    {
        return $this->adminMenuOrder;
    }

    /**
     * показать или нет модуль в панели управления
     *
     * @return bool
     */
    public function getIsShowInAdminMenu()
    {
        return true;
    }

    /**
     * разрешено ли выключение
     *
     * @return bool
     *
     * @since 0.5
     */
    public function getIsNoDisable()
    {
        return false;
    }

    /**
     * Массив с именами модулей и их зависимостями
     *
     * @return array
     *
     * @since 0.5
     */
    public function getModulesNoDisable()
    {
        $modulesNoDisable = Yii::app()->getCache()->get('YupeModulesNoDisable');
        if ($modulesNoDisable === false) {
            $modules = Yii::app()->moduleManager->getModules(false, true);
            $modulesNoDisable = [];

            foreach ($modules['modules'] as $module) {
                if ($module->getIsNoDisable()) {
                    $modulesNoDisable[] = $module->getId();
                }
            }

            Yii::app()->getCache()->set(
                'YupeModulesNoDisable',
                $modulesNoDisable,
                Yii::app()->getModule('yupe')->coreCacheTime,
                new TagsCache('yupe', 'installedModules')
            );
        }

        return $modulesNoDisable;
    }

    /**
     * Массив с именами модулей и их зависимостями
     *
     * @return array
     *
     * @since 0.5
     */
    public function getDependenciesAll()
    {
        $modulesDependent = Yii::app()->getCache()->get('YupeModulesDependenciesAll');
        if ($modulesDependent === false) {
            $modules = Yii::app()->moduleManager->getModules(false, true);
            $modulesDependent = [];

            foreach ($modules['modules'] as $module) {
                $dep = $module->getDependencies();
                if (!empty($dep) && is_array($dep)) {
                    $modulesDependent[$module->getId()] = $dep;
                }
            }
            Yii::app()->getCache()->set(
                'YupeModulesDependenciesAll',
                $modulesDependent,
                0,
                new TagsCache('installedModules', 'yupe')
            );
        }

        return $modulesDependent;
    }

    /**
     * Массив с именами модулей, от которых зависит работа данного модуля
     *
     * @return array
     *
     * @since 0.5
     */
    public function getDependencies()
    {
        return [];
    }

    /**
     * Массив с зависимостями модулей
     *
     * @return array
     *
     * @since 0.5
     */
    public function getDependents()
    {
        $modulesDependent = Yii::app()->getCache()->get('YupeModulesDependent');
        if ($modulesDependent === false) {
            $modules = $this->getDependenciesAll();
            foreach ($modules as $id => $dependencies) {
                foreach ($dependencies as $dependency) {
                    $modulesDependent[$dependency][] = $id;
                }
            }
            Yii::app()->getCache()->set(
                'YupeModulesDependent',
                $modulesDependent,
                0,
                new TagsCache('yupe', 'installedModules')
            );
        }

        return $modulesDependent;
    }

    /**
     * Массив с именами модулей которые зависят от текущего модуля
     *
     * @return array
     *
     * @since 0.5
     */
    public function getDependent()
    {
        $modulesDependent = $this->getDependents();

        return isset($modulesDependent[$this->id]) ? $modulesDependent[$this->id] : [];
    }

    /**
     * устанавливает checkbox включенным по умолчанию при установке Yupe
     *
     * @return bool
     *
     * @since 0.5
     */
    public function getIsInstallDefault()
    {
        return false;
    }

    /**
     * Метод определяет включен ли модуль
     *
     * @return bool
     *
     * @since 0.5
     */
    public function getIsActive()
    {
        $status = is_file(Yii::app()->basePath . '/config/modules/' . $this->getId() . '.php');
        if ($this->getId() == 'install') {
            $status = ($status == false) ? true : false;
        }

        return $status;
    }

    /**
     * Метод проверяет установлен ли модуль
     *
     * @return bool состояние модуля
     */
    public function getIsInstalled()
    {
        $modulesInstalled = Yii::app()->getCache()->get('YupeModulesInstalled');

        if ($modulesInstalled === false) {

            $modulesInstalled = Yii::app()->migrator->getInstalledModulesList();

            // Цепочка зависимостей:
            $chain = new CChainedCacheDependency();

            // Зависимость на каталог 'application.config.modules':
            $chain->dependencies->add(
                new CDirectoryCacheDependency(
                    Yii::getPathOfAlias('application.config.modules')
                )
            );

            // Зависимость на тег:
            $chain->dependencies->add(
                new TagsCache('installedModules', 'disabledModules', 'yupe', $this->getId())
            );

            Yii::app()->getCache()->set(
                'YupeModulesInstalled',
                $modulesInstalled,
                Yii::app()->getModule('yupe')->coreCacheTime,
                $chain
            );
        }

        if (!in_array($this->getId(), $modulesInstalled)) {
            return false;
        }

        $upd = Yii::app()->getCache()->get('YupeModuleUpdates_' . $this->getId());

        if ($upd === false) {
            $upd = Yii::app()->migrator->checkForUpdates([$this->getId() => $this]);

            // Цепочка зависимостей:
            $chain = new CChainedCacheDependency();

            // Зависимость на тег:
            $chain->dependencies->add(
                new TagsCache('installedModules', 'disabledModules', 'yupe', $this->getId())
            );

            // Зависимость на каталог 'application.config.modules':
            $chain->dependencies->add(
                new CDirectoryCacheDependency(
                    Yii::getPathOfAlias('application.config.modules')
                )
            );

            Yii::app()->getCache()->set(
                'YupeModuleUpdates_' . $this->getId(),
                $upd,
                Yii::app()->getModule('yupe')->coreCacheTime,
                $chain
            );
        }

        return in_array($this->getId(), $modulesInstalled) || count($upd);
    }

    /**
     * Метод включает модуль - копирует файл с конфигурацией
     *
     * @param boolean $noDependent - не проверять на зависимости от других модулей
     * @param boolean $updateConfig - обновить ли файл конфигурации
     *
     * @throws CException
     * @return bool       статус включения модуля
     *
     * @since 0.5
     */
    public function getActivate($noDependent = false)
    {
        Yii::app()->getCache()->flush();
        Yii::app()->configManager->flushDump();

        $fileConfig = Yii::app()->moduleManager->getModulesConfig($this->getId());

        if (is_file($fileConfig) && $this->id != ModuleManager::INSTALL_MODULE) {
            return true;
        } else {

            // Проверка модулей от которых зависит данный
            if (!$noDependent) {
                $dependencies = $this->getDependencies();
                if (!empty($dependencies) && is_array($dependencies)) {
                    foreach ($dependencies as $dependency) {
                        if (Yii::app()->getModule($dependency) == null) {
                            //установить все зависимости @since 0.8
                            $module = Yii::app()->moduleManager->getCreateModule($dependency);

                            if (null === $module) {
                                throw new CException(
                                    Yii::t(
                                        'YupeModule.yupe',
                                        'Error. Modules which depends from this module is disabled. First please enable this modules.'
                                    )
                                );
                            }

                            if ($module->getIsInstalled()) {
                                $this->getActivate();
                            } else {
                                $module->getInstall();
                            }
                        }
                    }
                }
            }

            if (Yii::app()->moduleManager->updateModuleConfig($this)) {
                return true;
            } else {
                throw new CException(
                    Yii::t(
                        'YupeModule.yupe',
                        'Error when trying to enable the module. Configuration file is corrupted or access to "config" folder is forbidden!'
                    )
                );
            }
        }
    }

    /**
     * Метод выключает модуль - удаляет файл конфигурации модуля
     *
     * @param boolean $noDependent - не проверять на зависимости от других модулей
     *
     * @throws CException
     * @return bool       статус включения модуля
     *
     * @since 0.5
     */
    public function getDeActivate($noDependent = false)
    {
        Yii::app()->getCache()->flush();
        Yii::app()->configManager->flushDump();

        $fileModule = Yii::app()->moduleManager->getModulesConfigDefault($this->id);
        $fileConfig = Yii::app()->moduleManager->getModulesConfig($this->id);
        $fileConfigBack = Yii::app()->moduleManager->getModulesConfigBack($this->id);

        if (!is_file($fileConfig) && $this->id != 'install') {
            throw new CException(Yii::t('YupeModule.yupe', 'Module already disabled!'));
        } else {
            // Проверка зависимых модулей
            if (!$noDependent) {
                $dependent = $this->getDependent();
                if (!empty($dependent) && is_array($dependent)) {
                    foreach ($dependent as $dependen) {
                        $module = Yii::app()->getModule($dependen);
                        if ($module != null) {
                            if($module->getIsNoDisable()) {
                                continue;
                            }
                            $module->getDeActivate();
                        }
                    }
                }
            }

            if ($this->getIsNoDisable()) {
                throw new CException(Yii::t('YupeModule.yupe', 'This module can\'t be disabled!'));
            } elseif (@md5_file($fileModule) != @md5_file($fileConfig) && !@copy($fileConfig, $fileConfigBack)) {
                throw new CException(
                    Yii::t(
                        'YupeModule.yupe',
                        "Error when coping old configuration file in modulesBack folder!"
                    )
                );
            } elseif (!@unlink($fileConfig)) {
                throw new CException(
                    Yii::t(
                        'YupeModule.yupe',
                        'Error when disabling module, there is no access to configuration file!'
                    )
                );
            } else {
                return true;
            }
        }

        return false;
    }

    /**
     * Метод устанавливающий модуль
     *
     * @return bool статус установки модуля
     *
     * @since 0.5
     */
    public function getInstall()
    {
        return ($this->id == ModuleManager::CORE_MODULE || $status = $this->getActivate()) ? $this->installDB(
        ) : $status;
    }

    /**
     * Метод удаляющий модуль
     * @throws CException
     * @return bool       статус удаления модуля
     * @since 0.5
     */
    public function getUnInstall()
    {
        if ($this->getIsActive()) {
            throw new CException(Yii::t('YupeModule.yupe', 'Disable module first!'));
        }

        return $this->uninstallDB();
    }

    /**
     * Метод установки БД модуля
     *
     * @param array &$installed - массив модуля
     *
     * @throws CException
     * @return bool       статус установки БД модуля
     *
     * @since 0.5
     */
    public function installDB($installed = [])
    {
        $log = [];
        Yii::log(
            Yii::t(
                'YupeModule.yupe',
                "{id}->installDB() : Requested DB installation of module {m}",
                ['{m}' => $this->getName(), '{id}' => $this->getId()]
            )
        );

        Yii::app()->getCache()->clear('installedModules', 'getModulesDisabled', 'modulesDisabled', $this->getId());
        Yii::app()->configManager->flushDump();

        if ($this->getDependencies() !== []) {
            foreach ($this->getDependencies() as $dep) {
                Yii::log(
                    Yii::t(
                        'YupeModule.yupe',
                        'First will be installed DB from module {m2} as a relation for {module}',
                        [
                            '{module}' => $this->getId(),
                            '{m2}'     => $dep,
                        ]
                    )
                );

                if (($m = Yii::app()->getModule($dep)) === null) {
                    //установить зависимости @since 0.8

                    $module = Yii::app()->moduleManager->getCreateModule($dep);

                    if (null === $module) {
                        throw new CException(
                            Yii::t(
                                'YupeModule.yupe',
                                "Module {dm} required for install was not found",
                                ['{dm}' => $dep]
                            )
                        );
                    }

                    if ($module->getIsInstalled()) {
                        $this->getActivate();
                    } else {
                        $module->getInstall();
                    }

                } else {
                    $i = $m->installDB($installed);
                    if (!isset($installed[$dep]) && !$i) {
                        return false;
                    }
                    $log = array_merge($log, $i);
                }
            }
        }
        $log[] = $this->getId();

        return (Yii::app()->migrator->updateToLatest($this->id) && ($installed[$this->id] = true)) ? $log : false;
    }

    /**
     * Метод удаляющий БД модуля
     *
     * @throws CException
     * @return bool       статус удаления БД модуля
     *
     * @since 0.5
     */
    public function uninstallDB()
    {
        Yii::log(
            Yii::t(
                'YupeModule.yupe',
                "{id}->uninstallDB() : Removing DB for {m} requested",
                ['{m}' => $this->name, '{id}' => $this->getId()]
            )
        );

        $history = Yii::app()->migrator->getMigrationHistory($this->getId(), -1);

        if (!empty($history)) {

            Yii::app()->getCache()->clear(
                'installedModules',
                $this->getId(),
                'yupe',
                'getModulesDisabled',
                'modulesDisabled',
                $this->getId()
            );
            Yii::app()->configManager->flushDump();

            $message = '';

            foreach ($history as $migrationName => $migrationTimeUp) {

                // удалить настройки модуля из таблички Settings
                Settings::model()->deleteAll(
                    'module_id = :module_id',
                    [
                        ':module_id' => $this->getId()
                    ]
                );

                if ($migrationTimeUp > 0) {
                    if (Yii::app()->migrator->migrateDown($this->getId(), $migrationName)) {
                        $message .= Yii::t(
                                'YupeModule.yupe',
                                '{m}: Migration was downgrade - {migrationName}',
                                [
                                    '{m}'             => $this->getId(),
                                    '{migrationName}' => $migrationName,
                                ]
                            ) . '<br />';
                    } else {
                        $message .= Yii::t(
                                'YupeModule.yupe',
                                '{m}: Can\'t downgrade migration - {migrationName}',
                                [
                                    '{m}'             => $this->getId(),
                                    '{migrationName}' => $migrationName,
                                ]
                            ) . '<br />';
                    }
                }
            }

            Yii::app()->user->setFlash(
                YFlashMessages::WARNING_MESSAGE,
                $message
            );

            return true;
        }

        throw new CException(Yii::t('YupeModule.yupe', 'Error when deleting module DB!'));
    }

    /**
     *  метод-хелпер именно для многих параметров модуля, где
     *  необходимо вывести варианты выбора да или нет
     *
     * @return array для многих параметров модуля необходимо вывести варианты выбора да или нет - метод-хелпер именно для этого
     */
    public function getChoice()
    {
        return [
            self::CHOICE_YES => Yii::t('YupeModule.yupe', 'yes'),
            self::CHOICE_NO  => Yii::t('YupeModule.yupe', 'no'),
        ];
    }

    /**
     * название иконки для меню админки, например 'user'
     *
     * @return string
     */
    public function getIcon()
    {
        return null;
    }

    /**
     * статус работы мультиязычности в модуле
     *
     * @return bool
     */
    public function isMultiLang()
    {
        return false;
    }

    /**
     * Инициализация модуля, считывание настроек из базы данных и их кэширование
     *
     * @return void
     */
    public function init()
    {
        parent::init();

        $this->getSettings();
    }

    /**
     * Получаем настройки модуля:
     *
     * @param boolean $needReset необходимо ли сбросить настройки
     *
     * @return void
     */
    public function getSettings($needReset = false)
    {
        if ($needReset) {
            Yii::app()->getCache()->clear($this->getId());
        }

        try {
            $settingsRows = Yii::app()->db
                ->cache($this->coreCacheTime, new \TagsCache($this->getId(), 'settings'))
                ->createCommand(
                    '
                    SELECT param_name, param_value
                        FROM {{yupe_settings}}
                        WHERE module_id = :module_id AND type = :type
                    '
                )
                ->bindValue(':module_id', $this->getId())
                ->bindValue(':type', Settings::TYPE_CORE)
                ->queryAll();

            if (!empty($settingsRows)) {

                foreach ($settingsRows as $sRow) {
                    if (property_exists($this, $sRow['param_name'])) {
                        $this->{$sRow['param_name']} = $sRow['param_value'];
                    }
                }
            }

            return true;

        } catch (CDbException $e) {
            return false;
        }
    }

    /**
     * Можно ли включить модуль
     *
     * @return bool
     **/
    public function canActivate()
    {
        return true;
    }

    /**
     * Необходимо ли удаление
     *
     * @return bool
     **/
    public function isNeedUninstall()
    {
        return !(Yii::app()->migrator->checkForUpdates((array)$this->getId()))
        && count(Yii::app()->migrator->getMigrationHistory($this->getId(), -1)) < 1;
    }

    /**
     * Проверяем настройки модуля, на необходимость обновления:
     *
     * @return bool
     **/
    public function isConfigNeedUpdate()
    {
        // Сверяем хеш суммы двух файлов
        // и возвращаем обратный результат
        // от полученного, то есть - требуется
        // ли обновление:

        $sourceFile = Yii::getPathOfAlias($this->getId() . '.install.' . $this->getId()) . '.php';

        $installedFile = Yii::getPathOfAlias('application.config.modules.' . $this->getId()) . '.php';

        if (!file_exists($sourceFile) || !file_exists($installedFile)) {
            return false;
        }

        return md5_file($sourceFile) !== md5_file($installedFile);
    }

    /**
     * Формат:
     * Имя правила обязательно начинать с "Модуль." - начало имени используется для определения принадлежности правила модулю
     * <pre>
     * array(
     *  array(
     *  'name' => 'Shop.Order.Management',
     *  'description' => 'Управление заказами',
     *  'type' => 1,
     *  'bizrule' => '',
     *  'items' => array(
     *      array(
     *          'name' => 'Shop.OrderBackend.Create',
     *          'description' => 'Создание заказа',
     *          'type' => 0,
     *          'bizrule' => '',
     *      ),
     *   ),
     *  )
     * )
     *
     * </pre>
     *
     * @since 0.8
     * @return array
     */
    public function getAuthItems()
    {
        return [];
    }

    /**
     * @since 0.8
     * Возвращает ссылку на опубликованную папку ресурсов
     * @uses $assetsPath
     * @return string|null
     * @throws \CException
     */
    public function getAssetsUrl()
    {
        if (!$this->assetsPath) {
            return null;
        }
        if (null === $this->_assetsUrl) {
            $this->_assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias($this->assetsPath));
        }
        return $this->_assetsUrl;
    }

    /**
     * @since 0.8
     * Возвращает Урл для странички настроек модуля
     * Для того чтобы можно было переопределить
     */
    public function getSettingsUrl()
    {
        return ['/yupe/backend/modulesettings', 'module' => $this->getId()];
    }

    /**
     * Возвращает класс виджета выбранного редактора
     *
     * @return string|null
     * @throws CException
     */
    public function getVisualEditor()
    {
        if ($this->visualEditor === null) {
            $yupe = Yii::app()->getModule('yupe');
            $editor = $this->editor ?: $yupe->editor;
            $this->visualEditor = isset($this->visualEditors[$editor]['class'])
                ? $this->visualEditors[$editor]['class']
                : $yupe->visualEditors[$editor]['class'];
        }
        return $this->visualEditor;
    }

    /**
     * Метод возвращает список доступных для использования в панели управления визуальных редакторов
     *
     * @since 0.4
     * @return array
     */
    public function getEditors()
    {
        return array_combine(array_keys($this->visualEditors), array_keys($this->visualEditors));
    }
}
