<?php
/**
 * YWebModule - базовый класс для всех модулей Юпи!
 *
 * Все модули, разработанные для Юпи! должны наследовать этот класс.
 * Панель управления Юпи!, собираемая из модулей, использует определенные методы этого базового класса.
 *
 * @category YupeModule
 * @package  YupeCms
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     http://yupe.ru
 *
 */
abstract class YWebModule extends CWebModule
{
    const CHECK_ERROR = 'error';
    const CHECK_NOTICE = 'notice';

    const CHOICE_YES = 1;
    const CHOICE_NO = 0;

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
     * @var array правила маршрутизации модуля (импортируются при старте модуля)
     */
    public $urlRules = null;
    /**
     * @var array редактор
     */
    public $editor = 'application.modules.yupe.widgets.editors.imperaviRedactor.ImperaviRedactorWidget';
    /**
     * @var array опции редактора
     */
    public $editorOptions = array();

    /**
     * @return string текущая версия модуля
     */
    public function getVersion()
    {
        return '0.1';
    }

    /**
     * @return string веб-сайт разработчика модуля или страничка самого модуля
     */
    public function getUrl()
    {
        return 'http://yupe.ru';
    }

    /**
     * @return string имя автора модуля
     */
    public function getAuthor()
    {
        return Yii::t('YupeModule.yupe', 'Сообщество Юпи!');
    }

    /**
     * @return string контактный email автора модуля
     */
    public function getAuthorEmail()
    {
        return 'support@yupe.ru';
    }

    /**
     * @return string ссылка которая будет отображена в панели управления
     *  как правило, ведет на страничку для администрирования модуля
     */
    public function getAdminPageLink()
    {
        return '/' . strtolower($this->id) . '/' . strtolower($this->defaultController) . '/index';
    }

    /**
     * @return string ссылка которая будет отображена в панели управления
     *  как правило, ведет на страничку для администрирования модуля
     */
    public function getAdminPageLinkNormalize()
    {
        return is_array($this->adminPageLink) ? $this->adminPageLink : array($this->adminPageLink);
    }

    /**
     * @return array если модуль должен добавить несколько ссылок в панель управления - укажите массив
     * @example
     *
     * public function getNavigation()
     * {
     *       return array(
     *           Yii::t('blog','Блоги')     => '/blog/blogAdmin/admin/',
     *           Yii::t('blog','Записи')    => '/blog/postAdmin/admin/',
     *           Yii::t('blog','Участники') => '/blog/BlogToUserAdmin/admin/',
     *      );
     * }
     *
     */
    public function getNavigation()
    {
        return false;
    }

    /**
     * @return array или false
     *   Работосопособность модуля может зависеть от разных факторов: версия php, версия Yii, наличие определенных модулей и т.д.
     *   В этом методе необходимо выполнить все проверки.
     * @example
     *   if (!$this->uploadPath)
     *        return array(
     *            'type' => YWebModule::CHECK_ERROR,
     *            'message' => Yii::t('image', 'Пожалуйста, укажите каталог для хранения изображений! {link}', array(
     *                '{link}' => CHtml::link(Yii::t('image', 'Изменить настройки модуля'), array('/yupe/backend/modulesettings/', 'module' => $this->id))
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
     * @return string каждый модуль должен принадлежать одной категории, именно по категорям делятся модули в панели управления
     */
    public function getCategory()
    {
        return null;
    }

    /**
     * @return array массив лейблов для параметров (свойств) модуля. Используется на странице настроек модуля в панели управления.
     */
    public function getParamsLabels()
    {
        return array('adminMenuOrder' => Yii::t('YupeModule.yupe', 'Порядок следования в меню'));
    }

    /**
     * @return array массив параметров модуля, которые можно редактировать через панель управления (GUI)
     */
    public function getEditableParams()
    {
        return array('adminMenuOrder');
    }

    /**
     * @return array массив групп параметров модуля, для группировки параметров на странице настроек
     */
    public function getEditableParamsGroups()
    {
        return array(
            'main' => array(
                'label' => Yii::t('YupeModule.yupe', 'Основные настройки модуля'),
                'items' => array(
                    'adminMenuOrder'
                )
            ),
        );
    }

    /**
     * @return array получение имена парамметров из getEditableParams()
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
     * @return int порядок следования модуля в меню панели управления (сортировка)
     */
    public function getAdminMenuOrder()
    {
        return $this->adminMenuOrder;
    }

    /**
     * @return bool показать или нет модуль в панели управления
     */
    public function getIsShowInAdminMenu()
    {
        return true;
    }

    /**
     * @return bool разрешено ли выключение
     * @since 0.5
     */
    public function getIsNoDisable()
    {
        return false;
    }

    /**
     * @return array Массив с именами модулей и их зависимостями
     * @since 0.5
     */
    public function getModulesNoDisable()
    {
        $modulesNoDisable = Yii::app()->cache->get('YupeModulesNoDisable');
        if ($modulesNoDisable === false) {
            $modules = Yii::app()->getModule('yupe')->getModules(false, true);
            $modulesNoDisable = array();

            foreach ($modules['modules'] as $module) {
                if ($module->isNoDisable) {
                    $modulesNoDisable[] = $module->id;
                }
            }
            Yii::app()->cache->set(
                'YupeModulesNoDisable',
                $modulesNoDisable,
                Yii::app()->getModule('yupe')->coreCacheTime
            );
        }
        return $modulesNoDisable;
    }

    /**
     * @return array Массив с именами модулей и их зависимостями
     * @since 0.5
     */
    public function getDependenciesAll()
    {
        $modulesDependent = Yii::app()->cache->get('YupeModulesDependenciesAll');
        if ($modulesDependent === false) {
            $modules = Yii::app()->getModule('yupe')->getModules(false, true);
            $modulesDependent = array();

            foreach ($modules['modules'] as $module) {
                if (!empty($module->dependencies) && is_array($module->dependencies)) {
                    $modulesDependent[$module->id] = $module->dependencies;
                }
            }
            Yii::app()->cache->set(
                'YupeModulesDependenciesAll',
                $modulesDependent,
                Yii::app()->getModule('yupe')->coreCacheTime
            );
        }
        return $modulesDependent;
    }

    /**
     * @return array Массив с именами модулей, от которых зависит работа данного модуля
     * @since 0.5
     */
    public function getDependencies()
    {
        return array();
    }

    /**
     * @return array Массив с зависимостями модулей
     * @since 0.5
     */
    public function getDependents()
    {
        $modulesDependent = Yii::app()->cache->get('YupeModulesDependent');
        if ($modulesDependent === false) {
            $modules = $this->dependenciesAll;
            foreach ($modules as $id => $dependencies) {
                foreach ($dependencies as $dependency) {
                    $modulesDependent[$dependency][] = $id;
                }
            }
            Yii::app()->cache->set(
                'YupeModulesDependent',
                $modulesDependent,
                Yii::app()->getModule('yupe')->coreCacheTime
            );
        }
        return $modulesDependent;
    }

    /**
     * @return array Массив с именами модулей которые зависят от текущего модуля
     * @since 0.5
     */
    public function getDependent()
    {
        $modulesDependent = $this->dependents;
        return isset($modulesDependent[$this->id]) ? $modulesDependent[$this->id] : array();
    }

    /**
     * @return bool устанавливает checkbox включенным по умолчанию при установке Yupe
     * @since 0.5
     */
    public function getIsInstallDefault()
    {
        return false;
    }

    /**
     * @return bool определяет, включен или выключен модуль
     * @since 0.5
     */
    public function getIsActive()
    {
        $status = is_file(Yii::app()->basePath . '/config/modules/' . $this->id . '.php');
        if ($this->id == 'install') {
            $status = ($status == false) ? true : false;
        }
        return $status;
    }

    /**
     * Getting is module installed
     * 
     * @return is installed
     */
    public function getIsInstalled()
    {
        $modulesInstalled = Yii::app()->cache->get('YupeModulesInstalled');
        if ($modulesInstalled === false) {
            $modulesInstalled = Yii::app()->migrator->modulesWithDBInstalled;
            Yii::app()->cache->set(
                'YupeModulesInstalled',
                $modulesInstalled,
                Yii::app()->getModule('yupe')->coreCacheTime
            );
        }

        $upd = Yii::app()->cache->get('YupeModuleUpdates_' . $this->id);
        if ($upd === false) {
            $upd = Yii::app()->migrator->checkForUpdates(array($this->id => $this));
            
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
                new TagsCache('installedModules')
            );

            Yii::app()->cache->set(
                'YupeModuleUpdates_' . $this->id,
                $upd,
                Yii::app()->getModule('yupe')->coreCacheTime,
                $chain
            );
        }
        return in_array($this->id, $modulesInstalled) || !count($upd);
    }

    /**
     *  Метод выключает модуль
     *
     * @param boolean $noDependen   - has dependents
     * @param boolean $updateConfig - is need to update config file
     *  
     * @return bool статус выключения модуля
     * 
     * @since 0.5
     */
    public function getActivate($noDependen = false, $updateConfig = false)
    {
        $yupe = Yii::app()->getModule('yupe');
        $fileModule = $yupe->getModulesConfigDefault($this->id);
        $fileConfig = $yupe->getModulesConfig($this->id);

        if (is_file($fileConfig) && $this->id != 'install' && $updateConfig === false) {
            throw new CException(Yii::t('YupeModule.yupe', 'Модуль уже включен!'), 304);
        } else {
            // Проверка модулей от которых зависит данный
            if (!$noDependen) {
                $dependencies = $this->dependencies;
                if (!empty($dependencies) && is_array($dependencies)) {
                    foreach ($dependencies as $dependency) {
                        if (Yii::app()->getModule($dependency) == null) {
                            throw new CException(
                                Yii::t(
                                    'YupeModule.yupe',
                                    'Произошла ошибка, модули от которых зависит этот модуль не включены, включите сначала их!'
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
                        'Произошла ошибка при включении модуля, конфигурационный файл поврежден или отсутствует доступ к папке config!'
                    )
                );
            }
        }
        return false;
    }

    /**
     *  Метод включает модуль
     *
     * @param boolean $noDependen - has dependen
     *  
     * @return bool статус включения модуля
     * 
     * @since 0.5
     */
    public function getDeActivate($noDependen = false)
    {
        $yupe = Yii::app()->getModule('yupe');
        $fileModule = $yupe->getModulesConfigDefault($this->id);
        $fileConfig = $yupe->getModulesConfig($this->id);
        $fileConfigBack = $yupe->getModulesConfigBack($this->id);

        if (!is_file($fileConfig) && $this->id != 'install') {
            throw new CException(Yii::t('YupeModule.yupe', 'Модуль уже отключен!'));
        } else {
            // Проверка зависимых модулей
            if (!$noDependen) {
                $dependent = $this->dependent;
                if (!empty($dependent) && is_array($dependent)) {
                    foreach ($dependent as $dependen) {
                        if (Yii::app()->getModule($dependen) != null) {
                            throw new CException(
                                Yii::t(
                                    'YupeModule.yupe',
                                    'Произошла ошибка, есть включенные зависимые модули, отключите сначало их!'
                                )
                            );
                            return false;
                        }
                    }
                }
            }

            if ($this->isNoDisable) {
                throw new CException(Yii::t('YupeModule.yupe', 'Этот модуль запрещено отключать!'));
            } elseif (@md5_file($fileModule) != @md5_file($fileConfig) && !@copy($fileConfig, $fileConfigBack)) {
                throw new CException(
                    Yii::t(
                        'YupeModule.yupe',
                        'Произошла ошибка при копировании старого конфигурационного файла в папку modulesBack!'
                    )
                );
            } elseif (!@unlink($fileConfig)) {
                throw new CException(
                    Yii::t(
                        'YupeModule.yupe',
                        'Произошла ошибка при отключении модуля, нет доступа к конфигурационному файлу!'
                    )
                );
            } else {
                return true;
            }
        }
        return false;
    }

    /**
     *  Метод устанавливающий модуль
     * @return bool статус установки модуля
     * @since 0.5
     */
    public function getInstall()
    {
        return ($this->id == 'yupe' || $status = $this->activate) ? $this->installDB() : $status;
    }

    /**
     * Метод удаляющий модуль
     * @return bool статус удаления модуля
     * @since 0.5
     */
    public function getUnInstall()
    {
        if ($this->isActive) {
            throw new CException(Yii::t('YupeModule.yupe', 'Сначала отключите модуль!'));
            return false;
        }
        return $this->uninstallDB();
    }

    /**
     * Метод установки БД модуля
     *
     * @param array &$installed - массив модулея
     * 
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
                "{id}->installDB() : Запрошена установка БД модуля {m}",
                array('{m}' => $this->name, '{id}' => $this->id)
            )
        );

        if ($this->dependencies !== array()) {
            foreach ($this->dependencies as $dep) {
                Yii::log(
                    Yii::t(
                        'YupeModule.yupe',
                        'Для модуля {module} сначала будет установлена база модуля {m2} как зависимость',
                        array(
                            '{module}' => $this->id,
                            '{m2}' => $dep,
                        )
                    )
                );

                if (($m = Yii::app()->getModule($dep)) == null) {
                    throw new CException(
                        Yii::t(
                            'YupeModule.yupe',
                            "Необходимый для установки модуль {dm} не найден",
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
        $log[] = $this->id;

        Yii::app()->cache->clear('installedModules');

        return (Yii::app()->migrator->updateToLatest($this->id) && ($installed[$this->id] = true)) ? $log : false;
    }

    /**
     * Метод удаляющий БД модуля
     * 
     * @return bool статус удаления БД модуля
     * 
     * @since 0.5
     */
    public function uninstallDB()
    {
        // @TODO Unused local variable $log
        $log = array();
        Yii::log(
            Yii::t(
                'YupeModule.yupe',
                "{id}->uninstallDB() : Запрошено удаление БД модуля {m}",
                array('{m}' => $this->name, '{id}' => $this->id)
            )
        );

        $history = Yii::app()->migrator->getMigrationHistory($this->id, -1);
        if (!empty($history)) {
            // Зачем?
            $message = '';
            foreach ($history as $migrationName => $migrationTimeUp) {
                if ($migrationTimeUp > 0) {
                    if (Yii::app()->migrator->migrateDown($this->id, $migrationName)) {
                        $message .= Yii::t(
                            'YupeModule.yupe',
                            '{m}: Произошёл откат миграции - {migrationName}',
                            array(
                                '{m}' => $this->id,
                                '{migrationName}' => $migrationName,
                            )
                        ) . '<br />';
                    } else {
                        $message .= Yii::t(
                            'YupeModule.yupe',
                            '{m}: Откат миграции {migrationName} неудалось провести.',
                            array(
                                '{m}' => $this->id,
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
            
            Yii::app()->cache->clear('installedModules');

            return true;
        }
        throw new CException(Yii::t('YupeModule.yupe', 'Произошла ошибка удаления БД модуля!'));
        return false;
    }

    /**
     * @return array для многих параметров модуля необходимо вывести варианты выбора да или нет - метод-хелпер именно для этого
     */
    public function getChoice()
    {
        return array(
            self::CHOICE_YES => Yii::t('YupeModule.yupe', 'да'),
            self::CHOICE_NO => Yii::t('YupeModule.yupe', 'нет'),
        );
    }

    /**
     * @return string название иконки для меню админки, например 'user'
     */
    public function getIcon()
    {
        return null;
    }

    /**
     * @return bool стутус работы мультиязычности в модуле
     */
    public function isMultiLang()
    {
        return false;
    }

    /**
     *  инициализация модуля, считывание настроек из базы данных и их кэширование
     */
    public function init()
    {
        parent::init();

        $settings = null;

        try {
            $settingsRows = Yii::app()->db
                ->cache($this->coreCacheTime, new TagsCache($this->getId(), 'settings'))
                ->createCommand('SELECT param_name, param_value
                                   FROM {{yupe_settings}}
                                   WHERE module_id = :module_id AND type = :type')
                ->bindValue(':module_id',$this->getId())
                ->bindValue(':type',Settings::TYPE_CORE)
                ->queryAll();

            foreach($settingsRows as $sRow){
                $settings[$sRow['param_name']] = $sRow['param_value'];
            }

        } catch (CDbException $e) {
            // Если базы нет, берем по-умолчанию, а не падаем в инсталлере - тут все равно падаем так как нотис не ловится кетчем
            $settings = null;
        }

        if (!empty($settings)) {
            foreach ($settings as $key => $value) {
                if(property_exists($this,$key)){
                    $this->{$key} = $value;
                }
            }
        }
    }

    //@TODO временное решение, пока не придумали куда перенести инициализацию editorOptions
    public function beforeControllerAction($controller, $action)
    {
        $uploadController = Yii::app()->createUrl('/yupe/backend/AjaxFileUpload');
        $this->editorOptions = array(
            'imageUpload' => $uploadController,
            'fileUpload' => $uploadController,
        );
        return true;
    }

    /**
     * Можно ли включить модуль:
     *
     * @return can activate module
     **/
    public function canActivate()
    {
        return true;
    }

    /**
     * Необходимо ли удаление
     *
     * @return is needed uninstalDb
     **/
    public function isNeedUninstall()
    {
        return !(Yii::app()->migrator->checkForUpdates((array) $this->getId()))
                && count(Yii::app()->migrator->getMigrationHistory($this->getId(), -1)) < 1;
    }

    /**
     * Проверяем настройки модуля, на необходимость обновления:
     *
     * @return is module config need update
     **/
    public function isConfigNeedUpdate()
    {
        // Сверяем хеш суммы двух файлов
        // и возвращаем обратный результат
        // от полученного, то есть - требуется
        // ли обновление:
        return !(
            md5_file(
                Yii::getPathOfAlias($this->getId() . '.install.' . $this->getId()) . '.php'
            ) === md5_file(
                Yii::getPathOfAlias('application.config.modules.' . $this->getId()) . '.php'
            )
        );
    }
}