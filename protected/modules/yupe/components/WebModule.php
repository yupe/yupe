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

use yupe\models\Settings;

abstract class WebModule extends CWebModule
{
    const CHECK_ERROR = 'error';
    const CHECK_NOTICE = 'notice';

    const CHOICE_YES = 1;
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
     * @var array редактор
     */
    public $editor = 'application.modules.yupe.widgets.editors.imperaviRedactor.ImperaviRedactorWidget';
    /**
     * @var array опции редактора
     */
    public $editorOptions = array();

    /**
     * @var array  Массив для задания обработчиков событий модуля при инициализации.
     *
     * @example
     *
     * $this->eventHandlers = array("onSomeEvent" => "someEventHandler");
     *
     * $this->eventHandlers = array( "onSomeEvent" => array(
     *                               "someEventHandler",
     *                               array(new EventClass,"eventHandlerMethod")
     *                              ));
     *
     * $this->eventHandlers = array("onFirstEvent" => array("someEventHandler","someEventHandler2"),
     *                              "onSecondEvent" => array(
     *                                 array(new EventClassOne,"eventHandlerMethodOne"),
     *                                 array(new EventClassTwo,"eventHandlerMethodTwo") )
     *                             );
     *
     */

    public $eventHandlers = array();

    /**
     * @var array список категорий
     */
    public function getCategoryList()
    {
        return \Category::model()->roots()->findAll();
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
        return is_array($this->adminPageLink) ? $this->adminPageLink : array($this->adminPageLink);
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
        return array('adminMenuOrder' => Yii::t('YupeModule.yupe', 'Menu items order'));
    }

    /**
     * массив параметров модуля, которые можно редактировать через панель управления (GUI)
     *
     * @return array
     */
    public function getEditableParams()
    {
        return array('adminMenuOrder');
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
        return array();
    }

    /**
     * Метод формирующий из массива "правил валидации для модуля" правила для указаного параметра
     *
     * @param $param Параметр для которого необходимо сформировать правила валидации
     * @return array Массив с правилами валидации для $param
     */
    public function getRulesForParam($param)
    {

        $rulesFromParam = new CList;
        foreach($this->rules() as $rule)
        {
            $params=preg_split('/[\s,]+/',$rule[0],-1,PREG_SPLIT_NO_EMPTY);
            if(in_array($param,$params))
            {
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
        return array(
            'main' => array(
                'label' => Yii::t('YupeModule.yupe', 'Main module settings'),
                'items' => array(
                    'adminMenuOrder'
                )
            ),
        );
    }

    /**
     * получение имен параметров из getEditableParams()
     *
     * @return array
     */
    public function getEditableParamsKey()
    {
        $keyParams = array();
        foreach ($this->editableParams as $key => $value) {
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
        $modulesNoDisable = Yii::app()->cache->get('YupeModulesNoDisable');
        if ($modulesNoDisable === false) {
            $modules = Yii::app()->moduleManager->getModules(false, true);
            $modulesNoDisable = array();

            foreach ($modules['modules'] as $module) {
                if ($module->getIsNoDisable()) {
                    $modulesNoDisable[] = $module->getId();
                }
            }

            Yii::app()->cache->set(
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
        $modulesDependent = Yii::app()->cache->get('YupeModulesDependenciesAll');
        if ($modulesDependent === false) {
            $modules = Yii::app()->moduleManager->getModules(false, true);
            $modulesDependent = array();

            foreach ($modules['modules'] as $module) {
                $dep = $module->getDependencies();
                if (!empty($dep) && is_array($dep)) {
                    $modulesDependent[$module->getId()] = $dep;
                }
            }
            Yii::app()->cache->set(
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
        return array();
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
        $modulesDependent = Yii::app()->cache->get('YupeModulesDependent');
        if ($modulesDependent === false) {
            $modules = $this->getDependenciesAll();
            foreach ($modules as $id => $dependencies) {
                foreach ($dependencies as $dependency) {
                    $modulesDependent[$dependency][] = $id;
                }
            }
            Yii::app()->cache->set(
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
        return isset($modulesDependent[$this->id]) ? $modulesDependent[$this->id] : array();
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
        $modulesInstalled = Yii::app()->cache->get('YupeModulesInstalled');

        if ($modulesInstalled === false) {
            $modulesInstalled = Yii::app()->migrator->modulesWithDBInstalled;

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

            Yii::app()->cache->set(
                'YupeModulesInstalled',
                $modulesInstalled,
                Yii::app()->getModule('yupe')->coreCacheTime,
                $chain
            );
        }

        if (!in_array($this->getId(), $modulesInstalled)) {
            return false;
        }

        $upd = Yii::app()->cache->get('YupeModuleUpdates_' . $this->getId());
        if ($upd === false) {
            $upd = Yii::app()->migrator->checkForUpdates(array($this->getId() => $this));

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

            Yii::app()->cache->set(
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
     * @param boolean $noDependen - не проверять на зависимости от других модулей
     * @param boolean $updateConfig - обновить ли файл конфигурации
     *
     * @throws CException
     * @return bool статус выключения модуля
     *
     * @since 0.5
     */
    public function getActivate($noDependen = false, $updateConfig = false)
    {
        $yupe = Yii::app()->getModule('yupe');
        $fileModule = Yii::app()->moduleManager->getModulesConfigDefault($this->getId());
        $fileConfig = Yii::app()->moduleManager->getModulesConfig($this->getId());

        Yii::app()->cache->clear('installedModules', 'getModulesDisabled', 'modulesDisabled', $this->getId());
        Yii::app()->configManager->flushDump();

        if (is_file($fileConfig) && $this->id != 'install' && $updateConfig === false) {
            throw new CException(Yii::t('YupeModule.yupe', 'Module already enabled!'), 304);
        } else {
            // Проверка модулей от которых зависит данный
            if (!$noDependen) {
                $dependencies = $this->getDependencies();
                if (!empty($dependencies) && is_array($dependencies)) {
                    foreach ($dependencies as $dependency) {
                        if (Yii::app()->getModule($dependency) == null) {
                            throw new CException(
                                Yii::t(
                                    'YupeModule.yupe',
                                    'Error. Modules which depends from this module is disabled. First please enable this modules.'
                                )
                            );
                            return false;
                        }
                    }
                }
            }

            // Если требуется обновление файла, выполняем unlink и копирование
            // иначе только через copy:
            if (($updateConfig && @unlink($fileConfig) && @copy($fileModule, $fileConfig)) || @copy($fileModule, $fileConfig)) {
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
        return false;
    }

    /**
     * Метод выключает модуль - удаляет файл конфигурации модуля
     *
     * @param boolean $noDependen - не проверять на зависимости от других модулей
     *
     * @throws CException
     * @return bool статус включения модуля
     *
     * @since 0.5
     */
    public function getDeActivate($noDependen = false)
    {
        $yupe = Yii::app()->getModule('yupe');
        $fileModule = Yii::app()->moduleManager->getModulesConfigDefault($this->id);
        $fileConfig = Yii::app()->moduleManager->getModulesConfig($this->id);
        $fileConfigBack = Yii::app()->moduleManager->getModulesConfigBack($this->id);

        Yii::app()->cache->clear('installedModules', 'getModulesDisabled', 'modulesDisabled', $this->getId());
        Yii::app()->configManager->flushDump();

        if (!is_file($fileConfig) && $this->id != 'install') {
            throw new CException(Yii::t('YupeModule.yupe', 'Module already disabled!'));
        } else {
            // Проверка зависимых модулей
            if (!$noDependen) {
                $dependent = $this->getDependent();
                if (!empty($dependent) && is_array($dependent)) {
                    foreach ($dependent as $dependen) {
                        if (Yii::app()->getModule($dependen) != null) {
                            throw new CException(
                                Yii::t(
                                    'YupeModule.yupe',
                                    'Error. You have enabled modules which depends for this module. Disable it first!'
                                )
                            );
                            return false;
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
                        'Error when coping old configuration file in modulesBack folder!'
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
        return ($this->id == 'yupe' || $status = $this->getActivate()) ? $this->installDB() : $status;
    }

    /**
     * Метод удаляющий модуль
     * @throws CException
     * @return bool статус удаления модуля
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
     * @param array &$installed - массив модулея
     *
     * @throws CException
     * @return bool статус установки БД модуля
     *
     * @since 0.5
     */
    public function installDB(&$installed = array())
    {
        $log = array();
        Yii::log(
            Yii::t(
                'YupeModule.yupe',
                "{id}->installDB() : Requested DB installation of module {m}",
                array('{m}' => $this->getName(), '{id}' => $this->getId())
            )
        );

        Yii::app()->cache->clear('installedModules', 'getModulesDisabled', 'modulesDisabled', $this->getId());
        Yii::app()->configManager->flushDump();

        if ($this->getDependencies() !== array()) {
            foreach ($this->getDependencies() as $dep) {
                Yii::log(
                    Yii::t(
                        'YupeModule.yupe',
                        'First will be installed DB from module {m2} as a relation for {module}',
                        array(
                            '{module}' => $this->getId(),
                            '{m2}' => $dep,
                        )
                    )
                );

                if (($m = Yii::app()->getModule($dep)) == null) {
                    throw new CException(
                        Yii::t(
                            'YupeModule.yupe',
                            "Module {dm} required for install was not found",
                            array('{dm}' => $dep)
                        )
                    );
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
     * @return bool статус удаления БД модуля
     *
     * @since 0.5
     */
    public function uninstallDB()
    {
        Yii::log(
            Yii::t(
                'YupeModule.yupe',
                "{id}->uninstallDB() : Removing DB for {m} requested",
                array('{m}' => $this->name, '{id}' => $this->getId())
            )
        );

        $history = Yii::app()->migrator->getMigrationHistory($this->getId(), -1);

        if (!empty($history)) {

            Yii::app()->cache->clear('installedModules', $this->getId(), 'yupe', 'getModulesDisabled', 'modulesDisabled', $this->getId());
            Yii::app()->configManager->flushDump();

            $message = '';

            foreach ($history as $migrationName => $migrationTimeUp) {

                // удалить настройки модуля из таблички Settings
                Settings::model()->deleteAll('module_id = :module_id',array(
                    ':module_id' => $this->getId()
                ));

                if ($migrationTimeUp > 0) {
                    if (Yii::app()->migrator->migrateDown($this->getId(), $migrationName)) {
                        $message .= Yii::t(
                            'YupeModule.yupe',
                            '{m}: Migration was downgrade - {migrationName}',
                            array(
                                '{m}' => $this->getId(),
                                '{migrationName}' => $migrationName,
                            )
                        ) . '<br />';
                    } else {
                        $message .= Yii::t(
                            'YupeModule.yupe',
                            '{m}: Can\'t downgrade migration - {migrationName}',
                            array(
                                '{m}' => $this->getId(),
                                '{migrationName}' => $migrationName,
                            )
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
        return array(
            self::CHOICE_YES => Yii::t('YupeModule.yupe', 'yes'),
            self::CHOICE_NO  => Yii::t('YupeModule.yupe', 'no'),
        );
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

        Yii::log("Init module '{$this->id}'...",CLogger::LEVEL_INFO);

        parent::init();

        $this->getSettings();

        $reflection  = new \ReflectionClass($this);
        if (is_array($this->eventHandlers)) {
            foreach ($this->eventHandlers as $handlerName => $connectedHandlers) {
                if ($reflection->hasMethod($handlerName)) {
                    if (is_array($connectedHandlers)) {
                        foreach ($connectedHandlers as $handler) {
                            $this->attachEventHandler($handlerName, $handler);
                        }
                    } else {
                        $this->attachEventHandler($handlerName, $connectedHandlers);
                    }
                }
            }
        }
    }

    /**
     * Получаем настройки модуля:
     *
     * @param  boolean $needReset необходимо ли сбросить настройки
     *
     * @return void
     */
    public function getSettings($needReset = false)
    {
        $settings = null;

        $needReset === false || Yii::app()->cache->clear($this->getId());

        try
        {
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

            foreach ($settingsRows as $sRow) {
                $settings[$sRow['param_name']] = $sRow['param_value'];
            }

        } catch (CDbException $e) {
            // Если базы нет, берем по-умолчанию, а не падаем в инсталлере - тут все равно падаем так как нотис не ловится кетчем
            $settings = null;
        }

        if (!empty($settings)) {
            foreach ($settings as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->{$key} = $value;
                }
            }
        }
    }

    /**
     * Временное решение
     *
     * @param Controller $controller - инстанс контроллера
     * @param Action     $action     - инстанс экшена
     *
     * @todo пока не придумали куда перенести инициализацию editorOptions
     *
     * @return bool
     **/
    public function beforeControllerAction($controller, $action)
    {
		$this->editorOptions = \CMap::mergeArray(
			array(
				'imageUpload' => Yii::app()->createUrl('/image/imageBackend/AjaxImageUpload'),
				'fileUpload'  => Yii::app()->createUrl('/image/imageBackend/AjaxFileUpload'),
				'imageGetJson'=> Yii::app()->createUrl('/image/imageBackend/AjaxImageChoose'),
			),
			$this->editorOptions
		);
		return true;
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
        return !(Yii::app()->migrator->checkForUpdates((array) $this->getId()))
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

        $installedFile = Yii::getPathOfAlias($this->getId() . '.install.' . $this->getId()) . '.php';

        if(!file_exists($sourceFile) || !file_exists($installedFile)) {
            return false;
        }

        return !(md5_file($sourceFile) === md5_file($installedFile));
    }
}