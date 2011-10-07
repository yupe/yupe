<?php
class Yupe extends CComponent
{
    public $coreModuleId = 'yupe';

    public $coreCacheTime = 3600;

    public function init()
    {
        $settings = Settings::model()->cache($this->coreCacheTime)->findAll('module_id = :module_id', array(':module_id' => $this->coreModuleId));

        foreach ($settings as $param)
        {
            $propertie = $param->param_name;

            if (property_exists($this, $propertie))
            {
                $this->$propertie = $param->param_value;
            }
        }
    }

    public function getVersion()
    {
        return '0.0.1';
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
                    {
                        $yiiModules[$key] = $module;
                    }
                }
            }

            asort($order, SORT_NUMERIC);

            foreach ($order as $key => $value)
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
                    {
                        array_push($modulesNavigation, $data);
                    }
                }

                // собрать все для меню "Настройки"
                if ($modules[$key]->getEditableParams())
                {
                    array_push($modulesNavigation['settings']['items'], array('label' => $modules[$key]->getName(), 'url' => array('/yupe/backend/modulesettings/', 'module' => $modules[$key]->getId())));
                }
            }
        }

        array_unshift($modulesNavigation['settings']['items'], array('label' => Yii::t('yupe', 'Оформление'), 'url' => array('/yupe/backend/themesettings/')));
        array_unshift($modulesNavigation, array('label' => Yii::t('yupe', 'На сайт'), 'url' => array('/')));
        array_push($modulesNavigation, array('label' => Yii::t('yupe', 'Войти'), 'url' => array('/site/login'), 'visible' => !Yii::app()->user->isAuthenticated()));
        array_push($modulesNavigation, array('label' => Yii::t('yupe', 'Выйти') . ' (' . Yii::app()->user->nick_name . ')', 'url' => array('/user/account/logout'), 'visible' => Yii::app()->user->isAuthenticated()));


        return $navigationOnly === true ? $modulesNavigation
            : array('modules' => $modules, 'yiiModules' => $yiiModules, 'modulesNavigation' => $modulesNavigation);
    }
}