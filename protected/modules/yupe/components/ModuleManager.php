<?php
/**
 * Компонент для управления модулями
 *
 * @category YupeComponent
 * @package  yupe.modules.yupe.components
 * @author   A.Opeykin <hello@amylabs.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.6
 * @link     http://yupe.ru
 *
 **/

namespace yupe\components;

use CChainedCacheDependency;
use CDirectoryCacheDependency;
use Exception;
use GlobIterator;
use TagsCache;
use Yii;
use yupe\widgets\YFlashMessages;
use yupe\helpers\YFile;

class ModuleManager extends \CApplicationComponent
{
    const CORE_MODULE = 'yupe';

    const INSTALL_MODULE = 'install';

    /**
     * @var
     */
    public $otherCategoryName;
    /**
     * @var
     */
    public $category;
    /**
     * @var
     */
    public $categoryIcon;
    /**
     * @var
     */
    public $categorySort;

    /**
     * Возвращаем список модулей:
     *
     * @param bool $navigationOnly - только навигация
     * @param bool $disableModule - отключённые модули
     *
     * @return mixed
     **/
    public function getModules($navigationOnly = false, $disableModule = false)
    {
        $this->otherCategoryName = Yii::t('YupeModule.yupe', 'Other');

        $this->categoryIcon = [
            Yii::t('YupeModule.yupe', 'Services') => 'fa fa-fw fa-briefcase',
            Yii::t('YupeModule.yupe', 'Yupe!')    => 'fa fa-fw fa-cog',
            Yii::t('YupeModule.yupe', 'Content')  => 'fa fa-fw fa-file',
            $this->otherCategoryName              => 'fa fa-fw fa-cog',
        ];

        $this->categorySort = [
            Yii::t('YupeModule.yupe', 'Users'),
            Yii::t('YupeModule.yupe', 'Content'),
            Yii::t('YupeModule.yupe', 'Structure'),
            Yii::t('YupeModule.yupe', 'Users'),
            Yii::t('YupeModule.yupe', 'Services'),
            Yii::t('YupeModule.yupe', 'Yupe!'),
            $this->otherCategoryName,
        ];

        $modules = $yiiModules = $order = [];
        $modulesExtendedNavigation = [];

        if (count(Yii::app()->getModules())) {
            /**
             * @todo внести получение модулей в кэш
             * Получаем модули и заполняем основные массивы
             **/
            foreach (Yii::app()->getModules() as $key => $value) {
                $key = strtolower($key);
                $module = Yii::app()->getModule($key);
                if (($module !== null)) {
                    if ($module instanceof WebModule) {
                        $category = (!$module->getCategory())
                            ? $this->otherCategoryName
                            : $module->getCategory();
                        $modules[$key] = $module;
                        $order[$category][$key] = $module->adminMenuOrder;
                        $moduleExNav = (array)$module->getExtendedNavigation();
                        $modulesExtendedNavigation = array_merge($modulesExtendedNavigation, $moduleExNav);
                    } else {
                        $yiiModules[$key] = $module;
                    }
                }
            }

            $modulesNavigation = Yii::app()->getCache()->get('YupeModulesNavigation-' . Yii::app()->getLanguage());

            if ($modulesNavigation === false) {

                // Формируем навигационное меню
                $modulesNavigation = [];

                // Шаблон настройка модулей
                $settings = [];

                // Сортируем категории модулей
                if (count($order) > 1) {
                    $categorySort = array_reverse($this->categorySort);

                    foreach ($categorySort as $iValue) {
                        if (isset($order[$iValue])) {
                            $orderValue = $order[$iValue];
                            unset($order[$iValue]);
                            $order = [$iValue => $orderValue] + $order;
                        }
                    }
                }

                $uniqueMenuId = 0;
                // Обходим категории модулей
                foreach ($order as $keyCategory => $valueCategory) {
                    $settings['items'] = [];

                    // Шаблон категорий
                    $modulesNavigation[$keyCategory] = [
                        'label'          => $keyCategory,
                        //'url' => '#',
                        'items'          => [],
                        'submenuOptions' => ["id" => "mainmenu_" . $uniqueMenuId]
                    ];
                    $uniqueMenuId++;

                    if (isset($this->categoryIcon[$keyCategory])) {
                        $modulesNavigation[$keyCategory]['icon'] = $this->categoryIcon[$keyCategory];
                    }

                    // Сортируем модули в категории
                    asort($valueCategory, SORT_NUMERIC);

                    // Обходим модули
                    foreach ($valueCategory as $key => $value) {
                        $modSettings = [];
                        // Собраются подпункты категории "Настройки модулей", кроме пункта Юпи
                        if ($modules[$key]->editableParams && $key != self::CORE_MODULE) {
                            $modSettings = [
                                '---',
                                [
                                    'icon'  => 'fa fa-fw fa-cog',
                                    'label' => Yii::t('YupeModule.yupe', 'Module settings'),
                                    'url'   => $modules[$key]->getSettingsUrl(),
                                ],
                            ];
                        }

                        // Проверка на вывод модуля в категориях, потребуется при отключении модуля
                        if (!$modules[$key]->getIsShowInAdminMenu()) {
                            continue;
                        }

                        // Если нет иконка для данной категории, подставляется иконка первого модуля
                        if (!isset($modulesNavigation[$keyCategory]['icon']) && $modules[$key]->icon) {
                            $modulesNavigation[$keyCategory]['icon'] = $modules[$key]->icon;
                        }

                        // Шаблон модулей
                        $data = [
                            'icon'           => $modules[$key]->icon,
                            'label'          => $modules[$key]->name,
                            'url'            => $modules[$key]->adminPageLinkNormalize,
                            'submenuOptions' => ["id" => "submenu_" . $key],
                            'items'          => [],
                        ];

                        // Добавляем подменю у модулей
                        $links = $modules[$key]->getNavigation();
                        if (is_array($links)) {
                            $data['items'] = $links;
                        } else {
                            unset($modSettings[0]);
                        }

                        if ($key !== self::CORE_MODULE) {
                            $data['items'] = array_merge(
                                $data['items'],
                                $key == self::CORE_MODULE ? [] : $modSettings
                            );
                        }

                        $modulesNavigation[$keyCategory]['items'][$modules[$key]->id] = $data;
                    }
                }

                // Заполняем категорию Юпи!
                // $this->category всегда пустая?
                //$modulesNavigation[$this->category]['items']['settings'] = $settings;

                // Цепочка зависимостей:
                $chain = new CChainedCacheDependency();

                // Зависимость на тег:
                $chain->dependencies->add(
                    new TagsCache('yupe', 'navigation', 'installedModules')
                );

                // Зависимость на каталог 'application.config.modules':
                $chain->dependencies->add(
                    new CDirectoryCacheDependency(
                        Yii::getPathOfAlias('application.config.modules')
                    )
                );

                Yii::app()->getCache()->set(
                    'YupeModulesNavigation-' . Yii::app()->language,
                    $modulesNavigation,
                    0,
                    $chain
                );
            }
        }

        // Подгрузка отключенных модулей
        if ($disableModule) {
            $modules += (array)$this->getModulesDisabled($modules);
        }

        $modulesNavigation = array_merge($modulesNavigation, $modulesExtendedNavigation);
        return ($navigationOnly === true) ? $modulesNavigation : [
            'modules'           => $modules,
            'yiiModules'        => $yiiModules,
            'modulesNavigation' => $modulesNavigation,
        ];
    }

    /**
     * Подгружает и выдает список отключенных модулей
     *
     * @param array $enableModule - список активных модулей, по умолчанию array()
     *
     * @since 0.5
     *
     * @return array список отключенных модулей
     */
    public function getModulesDisabled($enableModule = [])
    {
        if (($imports = Yii::app()->getCache()->get('pathForImports')) !== false) {
            Yii::app()->getModule('yupe')->setImport($imports);
        }

        try {

            if ($imports === false || ($modules = @Yii::app()->getCache()->get('modulesDisabled')) == false) {
                $modConfigs = Yii::getPathOfAlias('application.config.modules');
                $modPath = Yii::getPathOfAlias('application.modules');
                $cacheFile = Yii::app()->configManager->cacheFileName;

                foreach (new GlobIterator($modConfigs . '/*.php') as $item) {

                    if (is_dir(
                            $modPath . '/' . $item->getBaseName('.php')
                        ) == false && $cacheFile != $item->getBaseName('.php')
                    ) {

                        Yii::app()->getCache()->flush();

                        unlink($modConfigs . '/' . $item->getBaseName());

                        throw new Exception(
                            Yii::t(
                                'YupeModule.yupe',
                                'There is an error occurred when try get modules from the cache. It seems that module\'s folder was deleted. Module is {module}...',
                                [
                                    'module' => $item->getBaseName()
                                ]
                            )
                        );
                    }
                }

                $path = $this->getModulesConfigDefault();
                $enableModule = array_keys($enableModule);

                $modules = [];
                $imports = [];

                if ($handler = opendir($path)) {
                    while (($dir = readdir($handler))) {
                        if (!$this->isValidModule($dir)) {
                            continue;
                        }
                        if ($dir != '.' && $dir != '..' && !is_file($dir) && !isset($enableModule[$dir])) {
                            $modules[$dir] = $this->getCreateModule($dir);
                            $imports[] = Yii::app()->getCache()->get('tmpImports');
                        }
                    }
                    closedir($handler);
                }

                $chain = new CChainedCacheDependency();

                // Зависимость на тег:
                $chain->dependencies->add(
                    new TagsCache('yupe', 'modulesDisabled', 'getModulesDisabled', 'installedModules', 'pathForImports')
                );

                // Зависимость на каталог 'application.config.modules':
                $chain->dependencies->add(
                    new CDirectoryCacheDependency(
                        Yii::getPathOfAlias('application.config.modules')
                    )
                );

                Yii::app()->getCache()->set('modulesDisabled', $modules, 0, $chain);
                Yii::app()->getCache()->set('pathForImports', $imports, 0, $chain);
            }
        } catch (Exception $e) {

            Yii::app()->getCache()->flush();

            Yii::app()->user->setFlash(
                YFlashMessages::ERROR_MESSAGE,
                $e->getMessage()
            );

            Yii::log($e->__toString(), \CLogger::LEVEL_ERROR);

            return false;
        }

        return $modules;
    }

    /**
     * Подгружает модуль
     *
     * @param array $name - имя модуля
     *
     * @since  0.5
     * @return array класс модуля
     */
    public function getCreateModule($name)
    {
        if (Yii::app()->hasModule($name)) {
            return Yii::app()->getModule($name);
        }
        $path = $this->getModulesConfigDefault();
        $module = null;
        if ($path) {
            //посмотреть внутри файл с окончанием Module.php
            $files = glob($path . '/' . $name . '/' . '*Module.php');
            if (count($files) == 1) {
                $className = pathinfo($files[0], PATHINFO_FILENAME);
                Yii::app()->getCache()->set('tmpImports', 'application.modules.' . $name . '.' . $className);
                Yii::import('application.modules.' . $name . '.' . $className);
                $module = Yii::createComponent($className, $name, null, false);
            }
        }

        return $module;
    }

    /**
     * Получаем путь к папке или файлу с конфигурацией модуля(-ей)
     *
     * @param bool $module - Имя модуля
     *
     * @since 0.5
     * @return string путь к папке или файлу с конфигурацией модуля(-ей)
     */
    public function getModulesConfig($module = false)
    {
        return Yii::app()->getBasePath() . '/config/modules/' . ($module ? $module . '.php' : '');
    }

    /**
     * Получаем путь к папке или файлу с резервной конфигурацией модуля(-ей)
     *
     * @param string $module Имя модуля
     *
     * @since 0.5
     * @return string путь к папке или файлу с резервной конфигурацией модуля(-ей)
     */

    public function getModulesConfigBack($module = '')
    {
        $path = Yii::app()->getBasePath() . '/config/modulesBack/';

        return empty($module) ? $path : $path.$module.'.php';
    }

    /**
     * Получаем путь к папке c дефолтной конфигурацией модуля
     *
     * @param string $module Имя модуля
     *
     * @since 0.5
     * @return string путь к папке c дефолтной конфигурацией модуля или путь к модулям
     */
    public function getModulesConfigDefault($module = '')
    {
        return empty($module) ? Yii::getPathOfAlias('application.modules') :
            Yii::getPathOfAlias('application.modules.' . $module) . '/install/' . $module . '.php';
    }

    /**
     * Метод проверяет является ли каталог валидным модулем Yii/Yupe
     *
     * @param string $module - ID модуля
     *
     * @since 0.6
     *
     * @return boolean true - модуль валиде false - нет
     */
    public function isValidModule($module)
    {
        if (!$module) {
            return false;
        }

        $modulePath = Yii::app()->moduleManager->getModulesConfigDefault() . DIRECTORY_SEPARATOR . $module;

        if (!is_dir($modulePath)) {
            return false;
        }

        $files = glob($modulePath . DIRECTORY_SEPARATOR . '*Module.php');

        return empty($files) ? false : true;
    }

    /**
     * Обновить конфигурационный файл модуля
     *
     * @param  WebModule $module
     * @return bool
     * @since 0.8
     */
    public function updateModuleConfig(WebModule $module)
    {
        $newConfig = $this->getModulesConfigDefault($module->getId());

        $currentConfig = $this->getModulesConfig($module->getId());

        if ((!file_exists($currentConfig) || YFile::rmFile($currentConfig)) && YFile::cpFile(
                $newConfig,
                $currentConfig
            )
        ) {
            Yii::app()->configManager->flushDump();
            return true;
        }

        return false;
    }
}
