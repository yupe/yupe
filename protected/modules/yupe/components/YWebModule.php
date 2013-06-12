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
        return Yii::t('YupeModule.yupe', 'Сообщество Юпи!');
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
     * Работосопособность модуля может зависеть от разных факторов: версия php, версия Yii, наличие определенных модулей и т.д.
     * В этом методе необходимо выполнить все проверки.
     * 
     * @return array или false
     *   
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
     * каждый модуль должен принадлежать одной категории, именно по категорям делятся модули в панели управления
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
        return array('adminMenuOrder' => Yii::t('YupeModule.yupe', 'Порядок следования в меню'));
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
                'label' => Yii::t('YupeModule.yupe', 'Основные настройки модуля'),
                'items' => array(
                    'adminMenuOrder'
                )
            ),
        );
    }

    /**
     * получение имена парамметров из getEditableParams()
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
            $modules = Yii::app()->getModule('yupe')->getModules(false, true);
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
            $modules = Yii::app()->getModule('yupe')->getModules(false, true);
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

        if (!in_array($this->getId(), $modulesInstalled))
            return false;

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
        $fileModule = $yupe->getModulesConfigDefault($this->getId());
        $fileConfig = $yupe->getModulesConfig($this->getId());

        Yii::app()->cache->clear('installedModules', 'getModulesDisabled', 'modulesDisabled', $this->getId());

        if (is_file($fileConfig) && $this->id != 'install' && $updateConfig === false) {
            throw new CException(Yii::t('YupeModule.yupe', 'Модуль уже включен!'), 304);
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
        $fileModule = $yupe->getModulesConfigDefault($this->id);
        $fileConfig = $yupe->getModulesConfig($this->id);
        $fileConfigBack = $yupe->getModulesConfigBack($this->id);

        Yii::app()->cache->clear('installedModules', 'getModulesDisabled', 'modulesDisabled', $this->getId());

        if (!is_file($fileConfig) && $this->id != 'install') {
            throw new CException(Yii::t('YupeModule.yupe', 'Модуль уже отключен!'));
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
                                    'Произошла ошибка, есть включенные зависимые модули, отключите сначало их!'
                                )
                            );
                            return false;
                        }
                    }
                }
            }

            if ($this->getIsNoDisable()) {
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
            throw new CException(Yii::t('YupeModule.yupe', 'Сначала отключите модуль!'));
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
                "{id}->installDB() : Запрошена установка БД модуля {m}",
                array('{m}' => $this->getName(), '{id}' => $this->getId())
            )
        );

        Yii::app()->cache->clear('installedModules', 'getModulesDisabled', 'modulesDisabled', $this->getId());

        if ($this->getDependencies() !== array()) {
            foreach ($this->getDependencies() as $dep) {
                Yii::log(
                    Yii::t(
                        'YupeModule.yupe',
                        'Для модуля {module} сначала будет установлена база модуля {m2} как зависимость',
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
                "{id}->uninstallDB() : Запрошено удаление БД модуля {m}",
                array('{m}' => $this->name, '{id}' => $this->getId())
            )
        );

        $history = Yii::app()->migrator->getMigrationHistory($this->getId(), -1);

        if (!empty($history)) {
            
            Yii::app()->cache->clear('installedModules', $this->getId(), 'yupe', 'getModulesDisabled', 'modulesDisabled', $this->getId());
            
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
                            '{m}: Произошёл откат миграции - {migrationName}',
                            array(
                                '{m}' => $this->getId(),
                                '{migrationName}' => $migrationName,
                            )
                        ) . '<br />';
                    } else {
                        $message .= Yii::t(
                            'YupeModule.yupe',
                            '{m}: Откат миграции {migrationName} неудалось провести.',
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

        throw new CException(Yii::t('YupeModule.yupe', 'Произошла ошибка удаления БД модуля!'));
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
            self::CHOICE_YES => Yii::t('YupeModule.yupe', 'да'),
            self::CHOICE_NO  => Yii::t('YupeModule.yupe', 'нет'),
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
     * стутус работы мультиязычности в модуле
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
         
        Yii::log("init {$this->id} ...",CLogger::LEVEL_ERROR,'modinit'); 

        parent::init();

        $settings = null;

        try
        {
            $settingsRows = Yii::app()->db
                ->cache($this->coreCacheTime, new TagsCache($this->getId(), 'settings'))
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