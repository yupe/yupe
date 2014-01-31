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

use Yii;
use CChainedCacheDependency;
use CHtml;
use CDirectoryCacheDependency;
use TagsCache;
use GlobIterator;


class ModuleManager extends \CApplicationComponent
{
    const CORE_MODULE = 'yupe';

    public $otherCategoryName;
    public $category;
    public $categoryIcon;
    public $categorySort;

    public function init()
    {
        parent::init();
    }

    /**
     * Возвращаем список модулей:
     *
     * @param bool $navigationOnly - только навигация
     * @param bool $disableModule  - отключённые модули
     *
     * @return mixed
     **/
    public function getModules($navigationOnly = false, $disableModule = false)
    {
        $this->otherCategoryName = Yii::t('YupeModule.yupe', 'Other');

        $this->categoryIcon = array(
            Yii::t('YupeModule.yupe', 'Services') => 'briefcase',
            Yii::t('YupeModule.yupe', 'Yupe!')    => 'cog',
            $this->otherCategoryName => 'cog',
        );

        $this->categorySort = array(
            Yii::t('YupeModule.yupe', 'Content'),
            Yii::t('YupeModule.yupe', 'Structure'),
            Yii::t('YupeModule.yupe', 'Users'),
            Yii::t('YupeModule.yupe', 'Services'),
            Yii::t('YupeModule.yupe', 'Yupe!'),
            $this->otherCategoryName,
        );

        $modules = $yiiModules = $order = array();

        if (count(Yii::app()->modules)) {
            /**
             * @todo внести получение модулей в кэш
             * Получаем модули и заполняем основные массивы
             **/
            foreach (Yii::app()->modules as $key => $value) {
                $key = strtolower($key);
                $module = Yii::app()->getModule($key);
                if (($module !== null)) {
                    if ($module instanceof WebModule) {
                        $category = (!$module->category)
                            ? $this->otherCategoryName
                            : $module->category;
                        $modules[$key] = $module;
                        $order[$category][$key] = $module->adminMenuOrder;
                    } else {
                        $yiiModules[$key] = $module;
                    }
                }
            }

            $modulesNavigation = Yii::app()->cache->get('YupeModulesNavigation-' . Yii::app()->language);

            if ($modulesNavigation === false) {

                // Формируем навигационное меню
                $modulesNavigation = array();

                // Шаблон настройка модулей
                $settings = array();

                // Сортируем категории модулей
                if (count($order) > 1) {
                    $categorySort = array_reverse($this->categorySort);

                    foreach ($categorySort as $iValue) {
                        if (isset($order[$iValue])) {
                            $orderValue = $order[$iValue];
                            unset($order[$iValue]);
                            $order = array($iValue => $orderValue) + $order;
                        }
                    }
                }

                // Обходим категории модулей
                foreach ($order as $keyCategory => $valueCategory) {
                    // Настройки модуля, если таковые имеются:
                    $modSettings = array();
                    $settings['items'] = array();

                    // Шаблон категорий
                    $modulesNavigation[$keyCategory] = array(
                        'label' => $keyCategory,
                        'url' => '#',
                        'items' => array(),
                    );

                    if (isset($this->categoryIcon[$keyCategory])) {
                        $modulesNavigation[$keyCategory]['icon'] = $this->categoryIcon[$keyCategory];
                    }

                    // Сортируем модули в категории
                    asort($valueCategory, SORT_NUMERIC);

                    // Обходим модули
                    foreach ($valueCategory as $key => $value) {
                        // Собраются подпункты категории "Настройки модулей", кроме пункта Юпи
                        if ($modules[$key]->editableParams && $key != self::CORE_MODULE) {
                            $modSettings = array(
                                '---',
                                array(
                                    'icon'  => 'cog',
                                    'label' => Yii::t('YupeModule.yupe', 'Module settings'),
                                    'url'   => array('/yupe/backend/modulesettings', 'module' => $modules[$key]->id),
                                ),
                            );
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
                        $data = array(
                            'icon' => $modules[$key]->icon,
                            'label' => $modules[$key]->name,
                            'url' => $modules[$key]->adminPageLinkNormalize,
                            'items' => array(),
                        );

                        // Добавляем подменю у модулей
                        $links = $modules[$key]->getNavigation();
                        if (is_array($links)) {
                            $data['items'] = $links;
                        } else {
                            unset($modSettings[0]);
                        }

                        if ($key !== self::CORE_MODULE) {
                            $data['items'] = array_merge(
                                $data['items'], $key == self::CORE_MODULE ? array() : $modSettings
                            );
                        }

                        $modulesNavigation[$keyCategory]['items'][$modules[$key]->id] = $data;
                    }
                }
           
                // Заполняем категорию Юпи!
                $modulesNavigation[$this->category]['items']['settings'] = $settings;

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

                Yii::app()->cache->set(
                    'YupeModulesNavigation-' . Yii::app()->language,
                    $modulesNavigation,
                    0,
                    $chain
                );
            }
        }

        if (CHtml::normalizeUrl("/" . Yii::app()->controller->route) != '/yupe/backend/index'
            && Yii::app()->controller instanceof YBackendController
        ) {
            // Устанавливаем активную категорию
            $thisCategory = Yii::app()->controller->module->category
                ? Yii::app()->controller->module->category
                : $this->otherCategoryName;
            $thisCategory = & $modulesNavigation[$thisCategory];
            $thisCategory['active'] = true;

            // Устанавливаем активный модуль
            $thisModule = (
                (Yii::app(
                    )->controller->action->id == 'modulesettings' && isset($_GET['module']) && $_GET['module'] != self::CORE_MODULE) ||
                Yii::app()->controller->action->id == 'settings'
            ) ? 'settings' : Yii::app()->controller->module->getId();
            $thisModule = & $thisCategory['items'][$thisModule];
            if (!empty($thisModule)) {
                $thisModule['active'] = true;
            }

            unset($thisModule);
            unset($thisCategory);
        }

        // Подгрузка отключенных модулей
        if ($disableModule) {
            $modules += $this->getModulesDisabled($modules);
        }

        return ($navigationOnly === true) ? $modulesNavigation : array(
            'modules' => $modules,
            'yiiModules' => $yiiModules,
            'modulesNavigation' => $modulesNavigation,
        );
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
    public function getModulesDisabled($enableModule = array())
    {
        if (($imports = Yii::app()->cache->get('pathForImports')) !== false){
            Yii::app()->getModule('yupe')->setImport($imports);
        }

        try {
            if ($imports === false || ($modules = @Yii::app()->cache->get('modulesDisabled')) == false) {
                $modConfigs = Yii::getPathOfAlias('application.config.modules');
                $modPath = Yii::getPathOfAlias('application.modules');
                $cacheFile = Yii::app()->configManager->cacheFile;

                foreach (new GlobIterator($modConfigs . '/*.php') as $item) {

                    if (is_dir($modPath . '/' . $item->getBaseName('.php')) == false && $cacheFile != $item->getBaseName('.php')) {
                        Yii::app()->cache->flush();

                        unlink($modConfigs . '/' . $item->getBaseName());

                        throw new Exception(
                            Yii::t('YupeModule.yupe', 'There is an error occurred when try get modules from the cache. It seems that module\'s folder was deleted.')
                        );
                    }
                }

                $path = $this->getModulesConfigDefault();
                $enableModule = array_keys($enableModule);

                $modules = array();
                $imports = array();

                if ($handler = opendir($path)) {
                    while (($dir = readdir($handler))) {
                        if(!$this->isValidModule($dir)) {
                            continue;
                        }
                        if ($dir != '.' && $dir != '..' && !is_file($dir) && !isset($enableModule[$dir])) {
                            $modules[$dir] = $this->getCreateModule($dir);
                            $imports[] = Yii::app()->cache->get('tmpImports');
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

                Yii::app()->cache->set('modulesDisabled', $modules, 0, $chain);
                Yii::app()->cache->set('pathForImports', $imports, 0, $chain);
            }
        } catch (Exception $e) {
            Yii::app()->cache->flush();

            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                $e->getMessage()
            );

            return Yii::app()->controller->redirect(
                Yii::app()->getRequest()->url
            );
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
            // @TODO А если файлов не 1, добавить прочтение install/module.php
            if (count($files) == 1) {
                $className = pathinfo($files[0], PATHINFO_FILENAME);
                Yii::app()->cache->set('tmpImports', 'application.modules.' . $name . '.' . $className);
                Yii::import('application.modules.' . $name . '.' . $className);
                $module = Yii::createComponent($className, $name, null, false);
            }
        }
        return $module;
    }

    /**
     * Получаем путь к папке или файлу с конфигурацией модуля(-ей)
     *
     * @param string $module - Имя модуля
     *
     * @since 0.5
     * @return string путь к папке или файлу с конфигурацией модуля(-ей)
     */
    public function getModulesConfig($module = false)
    {
        return Yii::app()->basePath . '/config/modules/' . ($module ? $module . '.php' : '');
    }



    /**
     * Получаем путь к папке или файлу с резервной конфигурацией модуля(-ей)
     *
     * @param string $module Имя модуля
     *
     * @since 0.5
     * @return string путь к папке или файлу с резервной конфигурацией модуля(-ей)
     */

    public function getModulesConfigBack($module = false)
    {
        return Yii::app()->basePath . '/config/modulesBack/' . ($module ? $module . '.php' : '');
    }


    /**
     * Получаем путь к папке c дефолтной конфигурацией модуля
     *
     * @param string $module Имя модуля
     *
     * @since 0.5
     * @return string путь к папке c дефолтной конфигурацией модуля или путь к модулям
     */
    public function getModulesConfigDefault($module = false)
    {
        return ($module
            ? Yii::getPathOfAlias('application.modules.' . $module) . '/install/' . $module . '.php'
            : Yii::getPathOfAlias('application.modules'));
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
        if(!$module) {
            return false;
        }

        $modulePath = Yii::app()->moduleManager->getModulesConfigDefault().DIRECTORY_SEPARATOR.$module;

        if(!is_dir($modulePath)) {
            return false;
        }

        $files = glob($modulePath . DIRECTORY_SEPARATOR . '*Module.php');

        return empty($files) ? false : true;
    }
} 