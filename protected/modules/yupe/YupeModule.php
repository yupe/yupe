<?php
class YupeModule extends YWebModule
{
    public $siteDescription;

    public $siteName;

    public $siteKeyWords;

    public $backendLayout = 'application.modules.yupe.views.layouts.column2';
    
    public $emptyLayout = 'application.modules.yupe.views.layouts.empty';

    public $theme;

    public $brandUrl;

    public $coreCacheTime = 3600;

    public $coreModuleId = 'yupe';

    public function getVersion()
    {
        return '0.0.3';
    }

    public function checkSelf()
    {
        if (!is_writable(Yii::app()->runtimePath))        
            return array('type' => YWebModule::CHECK_ERROR, 'message' => Yii::t('yupe', 'Директория "{dir}" не досутпна для записи!',array('{dir}' => Yii::app()->runtimePath)));        

        if (!is_writable(Yii::app()->getAssetManager()->basePath))        
            return array('type' => YWebModule::CHECK_ERROR, 'message' => Yii::t('yupe', 'Директория "{dir}" не досутпна для записи!',array('{dir}' => Yii::app()->getAssetManager()->basePath)));        

        if (defined('YII_DEBUG') && YII_DEBUG)        
            return array('type' => YWebModule::CHECK_ERROR, 'message' => Yii::t('yupe', 'Yii работает в режиме отладки, пожалуйста, отключите его! <br/> <a href="http://www.yiiframework.ru/doc/guide/ru/topics.performance">Подробнее про улучшение производительности Yii приложений</a>'));        

        return true;
    }

    public function getParamsLabels()
    {
        return array(
            'siteDescription' => Yii::t('yupe', 'Описание сайта'),
            'siteName' => Yii::t('yupe', 'Название сайта'),
            'siteKeyWords' => Yii::t('yupe', 'Ключевые слова сайта'),
            'backendLayout' => Yii::t('yupe', 'Layout административной части'),
            'theme' => Yii::t('yupe', 'Тема'),            
            'coreCacheTime' => Yii::t('yupe','Время кэширования')
        );
    }

    public function getEditableParams()
    {
        return array('coreCacheTime','theme', 'backendLayout', 'siteName', 'siteDescription', 'siteKeyWords');
    }

    public function getAdminPageLink()
    {
        return '/yupe/backend/modulesettings/module/yupe';
    }

    public function getIsShowInAdminMenu()
    {
        return false;
    }

    public function getCategory()
    {
        return Yii::t('yupe', 'Ядрышко');
    }

    public function getName()
    {
        return Yii::t('yupe', 'Основные параметры');
    }

    public function getDescription()
    {
        return Yii::t('yupe', 'Без этого модуля ничего не работает =)');
    }

    public function getAuthor()
    {
        return Yii::t('yupe', 'xoma');
    }

    public function getAuthorEmail()
    {
        return Yii::t('yupe', 'aopeykin@yandex.ru');
    }

    public function getUrl()
    {
        return Yii::t('yupe', 'http://yupe.ru');
    }


    public function init()
    {
        parent::init();   

        $this->setImport(array(
                              'yupe.models.*',
                              'yupe.components.*',
                         ));
    }


    public function getModules($navigationOnly = false)
    {

        //@TODO сортировка модулей по adminMenuOrder позже переделать более оптимально
        //@TODO этот метод необходимо оптимизировать, но позже
        //@TODO возможно хватит добавления кэширования

        $modules = $category = $yiiModules = $order = array();

        $modulesNavigation = array(
            'settings' => array(
                'items' => array(),
                'label' => Yii::t('yupe', 'Настройки'),
                'url' => '#',
                'linkOptions' => array('class' => 'sub-menu')
            ));

        if (count(Yii::app()->modules))
        {
            foreach (Yii::app()->modules as $key => $value)
            {
                $key = strtolower($key);

                $module = Yii::app()->getModule($key);

                if (!is_null($module))
                {
                    if (is_a($module, 'YWebModule'))
                    {
                        if ($module->getIsShowInAdminMenu() || $module->getEditableParams() || ($module->getIsShowInAdminMenu() == false && is_array($module->checkSelf())))
                        {
                            $modules[$key] = $module;

                            $category[$key] = $module->getCategory();

                            $order[$key] = $module->adminMenuOrder;
                        }

                    }
                    else                    
                        $yiiModules[$key] = $module;                    
                }
            }

            asort($order, SORT_NUMERIC);

            foreach ($order as $key => $value)
            {
                $links = $modules[$key]->getNavigation();
                
                if(is_array($links))
                {                    
                    foreach ($links as $text => $url)
                    {
                        $tmp = array('label' => $text, 'url' => array($url));                        

                        if (!isset($modulesNavigation[$category[$key]]))
                        {
                            $modulesNavigation[$category[$key]]['items'] = array();
                            $modulesNavigation[$category[$key]]['label'] = $category[$key];
                            $modulesNavigation[$category[$key]]['linkOptions'] = array('class' => 'sub-menu');
                            $modulesNavigation[$category[$key]]['url'] = '#';
                        }
                        
                        array_push($modulesNavigation[$category[$key]]['items'], $tmp);   
                    }                    
                }
                else
                {
                    $data = array('label' => $modules[$key]->getName(), 'url' => array($modules[$key]->getAdminPageLink()));

                    if ($modules[$key]->getIsShowInAdminMenu())
                    {
                        if ($category[$key])
                        {
                            if (!isset($modulesNavigation[$category[$key]]))
                            {
                                $modulesNavigation[$category[$key]]['items'] = array();
                                $modulesNavigation[$category[$key]]['label'] = $category[$key];
                                $modulesNavigation[$category[$key]]['linkOptions'] = array('class' => 'sub-menu');
                                $modulesNavigation[$category[$key]]['url'] = '#';
                            }

                            array_push($modulesNavigation[$category[$key]]['items'], $data);
                        }
                        else                    
                            array_push($modulesNavigation, $data);                    
                    }

                    // собрать все для меню "Настройки"
                    if ($modules[$key]->getEditableParams())
                    {
                        array_push($modulesNavigation['settings']['items'], array('label' => $modules[$key]->getName(), 'url' => array('/yupe/backend/modulesettings/', 'module' => $modules[$key]->getId())));
                    }
                }
            }
        }

        //CVarDumper::dump($modulesNavigation,10,true);die();

        array_unshift($modulesNavigation['settings']['items'], array('label' => Yii::t('yupe', 'Оформление'), 'url' => array('/yupe/backend/themesettings/')));
        array_unshift($modulesNavigation, array('label' => Yii::t('yupe', 'На сайт'), 'url' => array('/')));
        array_push($modulesNavigation, array('label' => Yii::t('yupe', 'Войти'), 'url' => array('/site/login'), 'visible' => !Yii::app()->user->isAuthenticated()));
        array_push($modulesNavigation, array('label' => Yii::t('yupe', 'Выйти ({nick_name})',array('{nick_name}' => Yii::app()->user->nick_name)), 'url' => array('/user/account/logout'), 'visible' => Yii::app()->user->isAuthenticated()));        
        
        //CVarDumper::dump($modulesNavigation,10,true);die();
    
        return $navigationOnly === true ? $modulesNavigation
            : array('modules' => $modules, 'yiiModules' => $yiiModules, 'modulesNavigation' => $modulesNavigation);
    }
}