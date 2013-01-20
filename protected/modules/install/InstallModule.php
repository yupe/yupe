<?php
/**
 * Install Module Class
 * Класс модуля инсталятора:
 *
 * @category YupeModules
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @version  0.0.1
 * @link     http://yupe.ru
 **/

/**
 * Install Module Class
 * Класс модуля инсталятора:
 *
 * @category YupeModules
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @version  0.0.1
 * @link     http://yupe.ru
 **/
class InstallModule extends YWebModule
{
    /**
     * Проверка инсталятора:
     *
     * @return mixed/bool mixed - при найденных ошибках, иначе - true
     **/
    public function checkSelf()
    {
        $messages = array();

        if ($this->isActive)
            $messages[YWebModule::CHECK_ERROR][] = array(
                'type'    => YWebModule::CHECK_ERROR,
                'message' => Yii::t('yupe', 'У Вас активирован модуль "Установщик", после установки системы его необходимо отключить!')
            );

        return (isset($messages[YWebModule::CHECK_ERROR])) ? $messages : true;
    }

    /**
     * Получение алиаса шаблона:
     *
     * @return string main layuout alias
     **/
    public function getLayoutAlias()
    {
        return 'application.modules.install.views.layouts.main';
    }

    /**
     * Атрибуты для шагов:
     *
     * @param string $stepName - название шага/экшена
     *
     * @return mixed/string
     **/
    public function getInstallSteps($stepName = false)
    {
        $installSteps = array(
            'index'          => Yii::t('InstallModule.install', 'Шаг 1 из 8 : "Приветствие!"'),
            'environment'    => Yii::t('InstallModule.install', 'Шаг 2 из 8 : "Проверка окружения!"'),
            'requirements'   => Yii::t('InstallModule.install', 'Шаг 3 из 8 : "Проверка системных требований"'),
            'dbsettings'     => Yii::t('InstallModule.install', 'Шаг 4 из 8 : "Соединение с базой данных"'),
            'modulesinstall' => Yii::t('InstallModule.install', 'Шаг 5 из 8 : "Установка модулей"'),
            'createuser'     => Yii::t('InstallModule.install', 'Шаг 6 из 8 : "Создание учетной записи администратора"'),
            'sitesettings'   => Yii::t('InstallModule.install', 'Шаг 7 из 8 : "Настройки проекта"'),
            'finish'         => Yii::t('InstallModule.install', 'Шаг 8 из 8 : "Окончание установки"'),
        );
        if (isset($installSteps[$stepName]))
            return $installSteps[$stepName];
        else
            return $installSteps;
    }

    /**
     * Проверка завершённости шага:
     *
     * @param string $actionId - требуемый шаг для проверки
     *
     * @return bool завершён ли шаг
     **/
    public function isStepFinished($actionId = false)
    {
        if (!isset(Yii::app()->session['InstallForm']))
            Yii::app()->session['InstallForm'] = array();
        $session = Yii::app()->session['InstallForm'];

        if ((isset($session[$actionId . 'Finished'])) && ($session[$actionId . 'Finished'] === true))
            return true;
        return false;
    }

    /**
     * Создание навигационного меню для инсталятора:
     *
     * @return mixed меню
     **/
    public function getInstallMenu()
    {
        $installSteps = $this->getInstallSteps();
        $installMenu = array();
        $startUrl = '/' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/';
        foreach ($installSteps as $key => $value)
            $installMenu[] = array_merge(
                array(
                    'label' => $value,
                    'icon' => (
                        Yii::app()->controller->action->id == $key
                            ? 'arrow-right'
                            : (
                                $this->isStepFinished($key)
                                ? 'ok'
                                : 'remove'
                            )
                    ),
                    'itemOptions' => array( 'class' => (Yii::app()->controller->action->id == $key) ? 'current' : '' )
                ), (
                    $this->isStepFinished($key) !== true
                    ? array(
                        'disabled' => true,
                    )
                    : array(
                        'url'   => Yii::app()->createUrl($startUrl . $key),
                    )
                )
            );
        return $installMenu;
    }

    /**
     * Получаем Admin Page Link
     *
     * @return string
     **/
    public function getAdminPageLink()
    {
        return '/install/default/index';
    }

    /**
     * Получаем Editable Params
     *
     * @return bool
     **/
    public function getEditableParams()
    {
        return false;
    }

    /**
     * Получаем категорию
     *
     * @return string
     **/
    public function getCategory()
    {
        return Yii::t('InstallModule.install', 'Юпи!');
    }

    /**
     * Получаем название модуля
     *
     * @return string
     **/
    public function getName()
    {
        return Yii::t('InstallModule.install', 'Установщик');
    }

    /**
     * Показывать в админ.меню
     *
     * @return bool
     **/
    public function getIsShowInAdminMenu()
    {
        return false;
    }

    /**
     * Описание модуля
     *
     * @return string
     **/
    public function getDescription()
    {
        return Yii::t('InstallModule.install', 'Модуль для установки системы');
    }

    /**
     * Версия модуля
     *
     * @return string
     **/
    public function getVersion()
    {
        return Yii::t('InstallModule.install', '0.2');
    }

    /**
     * Автор модуля
     *
     * @return string
     **/
    public function getAuthor()
    {
        return Yii::t('InstallModule.install', 'yupe team');
    }

    /**
     * Email автора модуля
     *
     * @return string
     **/
    public function getAuthorEmail()
    {
        return Yii::t('InstallModule.install', 'team@yupe.ru');
    }

    /**
     * Адрес автора модуля
     *
     * @return string
     **/
    public function getUrl()
    {
        return Yii::t('InstallModule.install', 'http://yupe.ru');
    }

    /**
     * Иконка модуля
     *
     * @return string
     **/
    public function getIcon()
    {
        return "download-alt";
    }

    /**
     * Инициализация модуля
     *
     * @return nothing
     **/
    public function init()
    {
        $this->setImport(
            array(
                'install.forms.*',
                'install.models.*',
                'install.components.*',
            )
        );
    }
}