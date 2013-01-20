<?php
class InstallModule extends YWebModule
{
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

    public function isStepFinished()
    {
        return false;
    }

    public function getInstallMenu()
    {
        $installSteps = $this->getInstallSteps();
        $installMenu = array();
        $startUrl = '/' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/';
        foreach ($installSteps as $key => $value)
            $installMenu[] = array_merge(
                array(
                    'label' => $value,
                    'disabled' => $this->isStepFinished($key),
                    'icon' => (Yii::app()->controller->action->id == $key)
                                ? 'arrow-right'
                                : (
                                    $this->isStepFinished($key)
                                    ? 'ok'
                                    : 'remove'
                                ),
                    'itemOptions' => array( 'class' => (Yii::app()->controller->action->id == $key) ? 'current' : '' )
                ), (
                    $this->isStepFinished($key) === true
                    ? array()
                    : array(
                        'url'   => Yii::app()->createUrl($startUrl . $key),
                    )
                )
            );
        return $installMenu;
    }

    public function getAdminPageLink()
    {
        return '/install/default/index';
    }

    public function getEditableParams()
    {
        return false;
    }

    public function getCategory()
    {
        return Yii::t('InstallModule.install', 'Юпи!');
    }

    public function getName()
    {
        return Yii::t('InstallModule.install', 'Установщик');
    }

    public function getIsShowInAdminMenu()
    {
        return false;
    }

    public function getDescription()
    {
        return Yii::t('InstallModule.install', 'Модуль для установки системы');
    }

    public function getVersion()
    {
        return Yii::t('InstallModule.install', '0.2');
    }

    public function getAuthor()
    {
        return Yii::t('InstallModule.install', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('InstallModule.install', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('InstallModule.install', 'http://yupe.ru');
    }

    public function getIcon()
    {
        return "download-alt";
    }

    public function init()
    {
        $this->setImport(array(
            'install.forms.*',
            'install.models.*',
            'install.components.*',
        ));
    }
}