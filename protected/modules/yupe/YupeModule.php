<?php
/**
 * YupeModule файл класса.
 * Модуль yupe - основной модуль Юпи!
 *
 * Модуль yupe содержит в себе все основные компоненты, которые используются другими модулями
 * Это наше ядрышко.
 *
 * @category  YupeMudules
 * @package   yupe.modules.yupe
 * @author    Andrey Opeykin <team@yupe.ru>
 * @copyright 2009-2013 Yupe! Copyright &copy;
 * @license   BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version   0.5.3
 * @link      http://yupe.ru
 */

use yupe\components\WebModule;

/**
 * Class YupeModule
 */
class YupeModule extends WebModule
{
    /**
     *
     */
    const VERSION = '0.9';

    /**
     * @var
     */
    public $enableAssets;
    /**
     * @var
     */
    public $cache;

    /**
     * @var
     */
    public $siteDescription;
    /**
     * @var
     */
    public $siteName;
    /**
     * @var
     */
    public $siteKeyWords;

    /**
     * @var string
     */
    public $backendLayout = 'column2';
    /**
     * @var
     */
    public $backendTheme;
    /**
     * @var string
     */
    public $emptyLayout = 'empty';
    /**
     * @var
     */
    public $theme;

    /**
     * @var int
     */
    public $coreCacheTime = 3600;
    /**
     * @var string
     */
    public $coreModuleId = 'yupe';

    /**
     * @var string
     */
    public $uploadPath = 'uploads';
    /**
     * @var
     */
    public $email;

    /**
     * @var string
     */
    public $availableLanguages = 'ru,en,zh_cn';
    /**
     * @var string
     */
    public $defaultLanguage = 'ru';
    /**
     * @var string
     */
    public $defaultBackendLanguage = 'ru';

    /**
     * @var int
     */
    public $adminMenuOrder = -1;

    /**
     * @var string
     */
    public $profileModel = 'User';

    /**
     * @var
     */
    public $allowedIp;
    /**
     * @var int
     */
    public $hidePanelUrls = 0;

    /**
     * @var string
     */
    public $logo = 'images/logo.png';

    /**
     * @var array
     * @since 0.8
     *
     * Массив фильтров для контроллеров панели управления
     */
    protected $backEndFilters = [['yupe\filters\YBackAccessControl - error']];

    public $visualEditors = [
        'redactor' => [
            'class' => 'yupe\widgets\editors\RedactorEditor',
        ],
    ];

    /**
     * @return array
     * @since 0.8
     *
     * Вернет массив фильтров для контроллеров панели управления
     */
    public function getBackendFilters()
    {
        return $this->backEndFilters;
    }

    /**
     * @since 0.8
     *
     * Устанавливает массив фильтров для контроллеров панели управления
     */
    public function setBackendFilters($filters)
    {
        $this->backEndFilters = $filters;
    }

    /**
     * @param $filter
     * @since 0.8
     *
     * Добавить новый фильтр для контроллеров панели управления
     */
    public function addBackendFilter($filter)
    {
        $this->backEndFilters[] = $filter;
    }

    /**
     * Возвращаем версию:
     *
     * @return string
     **/
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * @return array
     */
    public function getAllowedIp()
    {
        if (strpos($this->allowedIp, ',')) {
            return explode(',', trim($this->allowedIp));
        }

        return array();
    }

    /**
     * @since 0.7
     */
    public function getLogo()
    {
        return Yii::app()->getTheme()->getAssetsUrl() . '/' . $this->logo;
    }

    /**
     * Проверка модуля на ошибки:
     *
     * @return bool/mixed - массив сообщений при ошибках или true если всё ок
     **/
    public function checkSelf()
    {
        $messages = array();

        if (Yii::app()->hasModule('install')) {
            $messages[WebModule::CHECK_ERROR][] = array(
                'type'    => WebModule::CHECK_ERROR,
                'message' => Yii::t(
                        'YupeModule.yupe',
                        'You have active " Install" module, you must disable it after installation! <a href="http://www.yiiframework.com/doc/guide/basics.module">More about Yii modules</a>'
                    ),
            );
        }

        if (Yii::app()->db->enableProfiling) {
            $messages[WebModule::CHECK_ERROR][] = array(
                'type'    => WebModule::CHECK_ERROR,
                'message' => Yii::t(
                        'YupeModule.yupe',
                        'Please, disable profiler (file /protected/config/db.php, parameter "enableProfiling")!'
                    ),
            );
        }

        if (Yii::app()->db->enableParamLogging) {
            $messages[WebModule::CHECK_ERROR][] = array(
                'type'    => WebModule::CHECK_ERROR,
                'message' => Yii::t(
                        'YupeModule.yupe',
                        'Please, disable logging (file /protected/config/db.php, parameter "enableParamLogging")!'
                    ),
            );
        }

        if (Yii::app()->hasModule('gii')) {
            $messages[WebModule::CHECK_ERROR][] = array(
                'type'    => WebModule::CHECK_ERROR,
                'message' => Yii::t(
                        'YupeModule.yupe',
                        'You have active "gii" module. You must disable it after installation! <a href="http://www.yiiframework.com/doc/guide/basics.module">More about Yii modules</a>'
                    ),
            );
        }

        $uploadPath = Yii::getPathOfAlias('webroot') . '/' . $this->uploadPath;

        if (!is_writable($uploadPath)) {
            $messages[WebModule::CHECK_ERROR][] = array(
                'type'    => WebModule::CHECK_ERROR,
                'message' => Yii::t(
                        'YupeModule.yupe',
                        'Directory "{dir}" is not available for write! {link}',
                        array(
                            '{dir}'  => $uploadPath,
                            '{link}' => CHtml::link(
                                    Yii::t('YupeModule.yupe', 'Change settings'),
                                    array('/yupe/backend/modulesettings/', 'module' => 'yupe')
                                ),
                        )
                    ),
            );
        }

        if (!is_writable(Yii::app()->runtimePath)) {
            $messages[WebModule::CHECK_ERROR][] = array(
                'type'    => WebModule::CHECK_ERROR,
                'message' => Yii::t(
                        'YupeModule.yupe',
                        'Directory "{dir}" is not available for write!',
                        array('{dir}' => Yii::app()->runtimePath)
                    ),
            );
        }

        if (!is_writable(Yii::app()->getAssetManager()->basePath)) {
            $messages[WebModule::CHECK_ERROR][] = array(
                'type'    => WebModule::CHECK_ERROR,
                'message' => Yii::t(
                        'YupeModule.yupe',
                        'Directory "{dir}" is not available for write!',
                        array('{dir}' => Yii::app()->getAssetManager()->basePath)
                    ),
            );
        }

        if (defined('YII_DEBUG') && YII_DEBUG) {
            $messages[WebModule::CHECK_ERROR][] = array(
                'type'    => WebModule::CHECK_ERROR,
                'message' => Yii::t(
                        'YupeModule.yupe',
                        'Yii is working in debug mode, please, disable it! <br/> <a href="http://www.yiiframework.com/doc/guide/topics.performance">More about Yii performance</a>'
                    ),
            );
        }

        if (!Yii::app()->db->schemaCachingDuration) {
            $messages[WebModule::CHECK_ERROR][] = array(
                'type'    => WebModule::CHECK_ERROR,
                'message' => Yii::t(
                        'YupeModule.yupe',
                        'Please, enable DB caching! <br/> <a href="http://www.yiiframework.com/doc/guide/topics.performance">More about Yii performance</a>'
                    ),
            );
        }

        return isset($messages[WebModule::CHECK_ERROR]) ? $messages : true;
    }

    /**
     * Возвращаем названия параметров:
     *
     * @return mixed
     **/
    public function getParamsLabels()
    {
        return array(
            'siteDescription'        => Yii::t('YupeModule.yupe', 'Site description'),
            'siteName'               => Yii::t('YupeModule.yupe', 'Site title'),
            'siteKeyWords'           => Yii::t('YupeModule.yupe', 'Site keywords'),
            'backendLayout'          => Yii::t('YupeModule.yupe', 'Layout of backend'),
            'backendTheme'           => Yii::t('YupeModule.yupe', 'Theme of backend'),
            'theme'                  => Yii::t('YupeModule.yupe', 'Frontend theme'),
            'coreCacheTime'          => Yii::t('YupeModule.yupe', 'Chacing time (sec.)'),
            'uploadPath'             => Yii::t('YupeModule.yupe', 'File uploads catalog (relative to the site root)'),
            'editor'                 => Yii::t('YupeModule.yupe', 'Visual editor'),
            'email'                  => Yii::t('YupeModule.yupe', 'Admin Email'),
            'availableLanguages'     => Yii::t(
                    'YupeModule.yupe',
                    'List of available languages (for example. ru,en,de)'
                ),
            'defaultLanguage'        => Yii::t('YupeModule.yupe', 'Default language'),
            'defaultBackendLanguage' => Yii::t('YupeModule.yupe', 'Default backend language'),
            'allowedIp'              => Yii::t('YupeModule.yupe', 'Allowed IP'),
            'hidePanelUrls'          => Yii::t('YupeModule.yupe', 'Hide panel urls'),
            'logo'                   => Yii::t('YupeModule.yupe', 'Logo'),
            'allowedExtensions'      => Yii::t('YupeModule.yupe', 'Allowed extensions (separated by comma)'),
            'mimeTypes'              => Yii::t('YupeModule.yupe', 'Mime types'),
            'maxSize'                => Yii::t('YupeModule.yupe', 'Maximum size (in bytes)'),

        );
    }

    /**
     * Возвращаем редактируемые параметры:
     *
     * @return mixed
     **/
    public function getEditableParams()
    {
        return array(
            'coreCacheTime',
            'theme'                  => $this->getThemes(),
            'backendTheme'           => $this->getThemes(true),
            'siteName',
            'siteDescription',
            'siteKeyWords',
            'uploadPath',
            'editor'                 => $this->getEditors(),
            'email',
            'availableLanguages',
            'defaultLanguage'        => $this->getLanguagesList(),
            'defaultBackendLanguage' => $this->getLanguagesList(),
            'allowedIp',
            'hidePanelUrls'          => $this->getChoice(),
            'logo',
            'allowedExtensions',
            'mimeTypes',
            'maxSize',
        );
    }

    /**
     * массив групп параметров модуля, для группировки параметров на странице настроек
     *
     * @return array
     */
    public function getEditableParamsGroups()
    {
        return array(
            'main'     => array(
                'label' => Yii::t('YupeModule.yupe', 'Main settings admin panel'),
                'items' => array(
                    'hidePanelUrls',
                    'allowedIp',
                    'email',
                    'coreCacheTime'
                )
            ),
            'site'     => array(
                'label' => Yii::t('YupeModule.yupe', 'Site settings'),
                'items' => array(
                    'logo',
                    'siteName',
                    'siteDescription',
                    'siteKeyWords'
                )
            ),
            'theme'    => array(
                'label' => Yii::t('YupeModule.yupe', 'Themes'),
                'items' => array(
                    'theme',
                    'backendTheme'
                )
            ),
            'language' => array(
                'label' => Yii::t('YupeModule.yupe', 'Language settings'),
                'items' => array(
                    'availableLanguages',
                    'defaultLanguage',
                    'defaultBackendLanguage',
                )
            ),
            'editors'  => array(
                'label' => Yii::t('YupeModule.yupe', 'Visual editors settings'),
                'items' => array(
                    'editor',
                    'uploadPath',
                    'allowedExtensions',
                    'mimeTypes',
                    'maxSize',
                )
            ),
        );
    }

    /**
     * Возвращаем правила валидации для параметров модуля
     *
     * @return array Правила валидации для параметров модуля
     */
    public function rules()
    {
        return array(
            array(
                'availableLanguages',
                'filter',
                'filter' => function ($str) {
                        return preg_replace('/\s+/', '', $str);
                    }
            ),
        );
    }

    /**
     * Возвращаем статус, устанавливать ли галку для установки модуля в инсталяторе по умолчанию:
     *
     * @return bool
     **/
    public function getIsInstallDefault()
    {
        return true;
    }

    /**
     * Возвращаем статус, возможно ли модуль отключать:
     *
     * @return bool
     **/
    public function getIsNoDisable()
    {
        return true;
    }

    /**
     * Возвращаем массив языков:
     *
     * @return mixed
     **/
    public function getLanguagesList()
    {
        $langs = array();
        foreach (explode(',', $this->availableLanguages) as $lang) {
            $langs[$lang] = Yii::app()->getLocale()->getLocaleDisplayName($lang);
        }

        return $langs;
    }

    /**
     * Возвращаем линк на админ панель:
     *
     * @return mixed
     **/
    public function getAdminPageLink()
    {
        return '/yupe/backend/settings';
    }

    /**
     * Возвращаем массив меню:
     *
     * @return mixed
     **/
    public function getNavigation()
    {
        return array(
            array(
                'label'       => Yii::t('YupeModule.yupe', 'Clean cache'),
                'url'         => array('/yupe/backend/ajaxflush', 'method' => 1),
                'linkOptions' => array(
                    'class'  => 'flushAction',
                    'method' => 'cacheAll',
                ),
                'icon'        => 'fa fa-fw fa-trash-o',
                'items'       => array(
                    array(
                        'icon'        => 'fa fa-fw fa-trash-o',
                        'label'       => Yii::t('YupeModule.yupe', 'Clean settings cache'),
                        'url'         => array('/yupe/backend/flushDumpSettings'),
                        'linkOptions' => array(
                            'class'  => 'flushAction',
                            'method' => 'cacheFlush',
                        )
                    ),
                    array(
                        'icon'        => 'fa fa-fw fa-trash-o',
                        'label'       => Yii::t('YupeModule.yupe', 'Clean cache'),
                        'url'         => array('/yupe/backend/ajaxflush', 'method' => 1),
                        'linkOptions' => array(
                            'class'  => 'flushAction',
                            'method' => 'cacheFlush',
                        )
                    ),
                    array(
                        'icon'        => 'fa fa-fw fa-trash-o',
                        'label'       => Yii::t('YupeModule.yupe', 'Clean assets'),
                        'url'         => array('/yupe/backend/ajaxflush', 'method' => 2),
                        'linkOptions' => array(
                            'class'  => 'flushAction',
                            'method' => 'assetsFlush',
                        )
                    ),
                    array(
                        'icon'        => 'fa fa-fw fa-trash-o',
                        'label'       => Yii::t('YupeModule.yupe', 'Clean cache and assets'),
                        'url'         => array('/yupe/backend/ajaxflush', 'method' => 3),
                        'linkOptions' => array(
                            'class'  => 'flushAction',
                            'method' => 'cacheAssetsFlush',
                        )
                    ),
                )
            ),
            array(
                'icon'  => "fa fa-fw fa-th",
                'label' => Yii::t('YupeModule.yupe', 'Modules'),
                'url'   => array('/yupe/backend/settings'),
            ),
            array(
                'icon'  => 'fa fa-fw fa-picture-o',
                'label' => Yii::t('YupeModule.yupe', 'Theme settings'),
                'url'   => array('/yupe/backend/themesettings'),
            ),
            array(
                'icon'  => 'fa fa-fw fa-wrench',
                'label' => Yii::t('YupeModule.yupe', 'Site settings'),
                'url'   => $this->getSettingsUrl(),
            ),
            array(
                'icon'  => "fa fa-fw fa-question-circle",
                'label' => Yii::t('YupeModule.yupe', 'About Yupe!'),
                'url'   => array('/yupe/backend/help'),
            )
        );
    }

    /**
     * Возвращаем название категории модуля:
     *
     * @return string
     **/
    public function getCategory()
    {
        return Yii::t('YupeModule.yupe', 'Yupe!');
    }

    /**
     * Возвращаем название модуля:
     *
     * @return string
     **/
    public function getName()
    {
        return Yii::t('YupeModule.yupe', 'Yupe!');
    }

    /**
     * Возвращаем описание модуля:
     *
     * @return string
     **/
    public function getDescription()
    {
        return Yii::t('YupeModule.yupe', 'Yupe core!');
    }

    /**
     * Возвращаем автора модуля:
     *
     * @return string
     **/
    public function getAuthor()
    {
        return 'yupe team';
    }

    /**
     * Возвращаем почту автора модуля:
     *
     * @return string
     **/
    public function getAuthorEmail()
    {
        return Yii::t('YupeModule.yupe', 'team@yupe.ru');
    }

    /**
     * Возвращаем адрес на сайт автора модуля:
     *
     * @return string
     **/
    public function getUrl()
    {
        return Yii::t('YupeModule.yupe', 'http://yupe.ru');
    }

    /**
     * Возвращаем иконка модуля:
     *
     * @return string
     **/
    public function getIcon()
    {
        return "fa fa-fw fa-cog";
    }

    /**
     * Инициализация модуля:
     *
     * @return void
     **/
    public function init()
    {
        parent::init();
    }

    /**
     * Получает полный алиас нужного лайаута бэкенда с учетом темы
     *
     * @param string $layoutName Название лайаута, если не задан - берется по-умолчанию для бекенда
     *
     * @since 0.4
     * @return string Полный путь к лайауту
     */
    public function getBackendLayoutAlias($layoutName = '')
    {
        if ($this->backendTheme) {
            return 'themes.backend_' . $this->backendTheme . '.views.yupe.layouts.' . ($layoutName ? $layoutName : $this->backendLayout);
        } else {
            return 'application.modules.yupe.views.layouts.' . ($layoutName ? $layoutName : $this->backendLayout);
        }
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

    /**
     * Метод возвращает доступные темы оформления
     *
     * Для добавления новой темы необходимо:
     * Прочитать http://yiiframework.ru/doc/guide/ru/topics.theming
     * Скопировать тему в каталог  WebRoot/themes или аналогичный (настройки themeManager)
     * Название каталога с темой для панели управления должно начинаться с префикса "backend_", например "backend_bootstrap"
     *
     * @param bool $backend - если установлен в true - вернет темы оформления для панели управления, иначе - для публичной части сайта
     *
     * @return array список доступных тем
     * @since 0.4
     * @todo возможно, стоит добавить кэширование чтобы каждый раз не ходить по файловой системе
     */
    public function getThemes($backend = false)
    {
        $themes = array();

        if (isset(Yii::app()->themeManager->basePath) && $handler = opendir(Yii::app()->themeManager->basePath)) {
            while (($file = readdir($handler))) {
                if ($file != '.' && $file != '..' && !is_file($file)) {
                    if ("backend_" == substr($file, 0, 8)) {
                        if ($backend) {
                            $file = str_replace("backend_", "", $file);
                            $themes[$file] = $file;
                        }
                    } else {
                        if (!$backend) {
                            $themes[$file] = $file;
                        }
                    }
                }
            }
            closedir($handler);
        }

        return $themes;
    }

    /**
     * Метод возвращает пункты, содержащие сабменю для заголовок групп
     *
     * @param array $menu - список пунктов
     *
     * @since 0.5
     * @return array преобразованный список пунктов
     */
    public function getSubMenu($menu)
    {
        $items = array();
        end($menu);
        $endItemKey = key($menu);
        foreach ($menu as $key => $item) {
            if ($key === '') {
                continue;
            }
            if (isset($item['items']) && is_array($item['items'])) {
                $subItems = $item['items'];
                unset($item['items'], $item['icon'], $item['url']);
                $items[] = $item;
                $items = array_merge($items, $subItems);
                if ($key != $endItemKey) {
                    $items[] = "---";
                }
            } else {
                $items[] = $item;
            }
        }

        return $items;
    }

    /**
     * Выдает путь к стилям, определяет вкелючена тема или нет
     *
     * @since 0.5
     * @return string путь к директории
     */
    public function getThemeBaseUrl()
    {
        return (Yii::app()->theme) ? Yii::app()->theme->baseUrl : Yii::app()->baseUrl;
    }

    /**
     * Выдает массив для меню в административной панеле
     *
     * @since 0.5
     * @return array массив меню
     */
    public function getLanguageSelectorArray()
    {
        $langs = explode(',', $this->availableLanguages);

        if (count($langs) <= 1) {
            return array();
        }

        if (!Yii::app()->getUrlManager() instanceof \yupe\components\urlManager\LangUrlManager) {
            Yii::log(
                'For use multi lang, please, enable "upe\components\urlManager\LangUrlManager" as default UrlManager',
                CLogger::LEVEL_WARNING
            );

            return array();
        }

        $items = array();
        $currentLanguage = Yii::app()->language;

        $homeUrl = Yii::app()->homeUrl . (Yii::app()->homeUrl[strlen(Yii::app()->homeUrl) - 1] != "/" ? '/' : '');
        $cp = Yii::app()->urlManager->getCleanUrl(Yii::app()->getRequest()->url);

        foreach ($langs as $lang) {
            $lang = trim($lang);
            if ($lang == $currentLanguage) {
                continue;
            } else {
                $items[] = array(
                    'icon'  => 'iconflags iconflags-' . $lang,
                    'label' => Yii::t('YupeModule.yupe', $lang),
                    'url'   => $homeUrl . Yii::app()->urlManager->replaceLangUrl($cp, $lang),
                );
            }
        }

        return array(
            array(
                'icon'           => 'iconflags iconflags-' . $currentLanguage,
                'label'          => Yii::t('YupeModule.yupe', $currentLanguage),
                'items'          => $items,
                'submenuOptions' => array('style' => 'min-width: 20px;'),
            )
        );
    }

    /**
     * Генерация анкора PoweredBy
     *
     * @param string $color - цвет
     * @param string $text - текст
     *
     * @return string poweredBy
     */
    public function poweredBy($color = 'yellow', $text = '')
    {
        if (empty($text)) {
            $text = Yii::t('YupeModule.yupe', 'Powered by Yupe!');
        }

        return CHtml::link(
            CHtml::image(
                Yii::app()->getAssetManager()->publish(
                    Yii::getPathOfAlias('application.modules.yupe.views.assets')
                ) . "/img/yupe_{$color}.png",
                $text
            ),
            'http://yupe-project.ru?from=pb',
            array('title' => CHtml::encode($text), 'alt' => CHtml::encode($text))
        );
    }

    /**
     * Получаем массив с именами модулей, от которых зависит работа данного модуля
     *
     * @return array Массив с именами модулей, от которых зависит работа данного модуля
     *
     * @since 0.5
     */
    public function getDependencies()
    {
        return array('user');
    }

    /**
     * @return array
     */
    public function getLayoutsList()
    {
        $data = array();

        foreach (new GlobIterator(Yii::app()->getTheme(
            )->basePath . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . '*.php') as $item) {
            $name = $item->getBaseName('.php');
            $data[$name] = $name;
        }

        return $data;
    }


    public function getAuthItems()
    {
        return array(
            array(
                'name'        => 'ManageYupeParams',
                'description' => Yii::t('YupeModule.yupe', 'Modules update'),
                'type'        => AuthItem::TYPE_TASK,
                'items'       => array(
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Yupe.YupeBackend.index',
                        'description' => Yii::t('YupeModule.yupe', 'Yupe panel')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Update.UpdateBackend.update',
                        'description' => Yii::t('YupeModule.yupe', 'Modules update')
                    ),
                )
            )
        );
    }
}
