<?php
/**
 * InstallModule основной класс модуля install
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amylabs && Yupe! team
 * @package yupe.modules.install
 * @since 0.1
 *
 */

use yupe\components\WebModule;

class InstallModule extends WebModule
{
    /**
     * Проверка инсталятора:
     *
     * @return mixed/bool mixed - при найденных ошибках, иначе - true
     **/
    public function checkSelf()
    {
        $messages = [];

        if ($this->getIsActive()) {
            $messages[WebModule::CHECK_ERROR][] = [
                'type'    => WebModule::CHECK_ERROR,
                'message' => Yii::t(
                    'InstallModule.install',
                    'You have "Insatll" module active! After install it need to be disabled!'
                )
            ];
        }

        return (isset($messages[WebModule::CHECK_ERROR])) ? $messages : true;
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
     * @param bool|string $stepName - название шага/экшена
     *
     * @return mixed/string
     */
    public function getInstallSteps($stepName = false)
    {
        $installSteps = [
            'index'          => Yii::t('InstallModule.install', 'Step 1 of 8: Welcome!'),
            'environment'    => Yii::t('InstallModule.install', 'Step 2 of 8: Environment check!'),
            'requirements'   => Yii::t('InstallModule.install', 'Step 3 of 8: System requirements'),
            'dbsettings'     => Yii::t('InstallModule.install', 'Step 4 of 8: DB settings'),
            'modulesinstall' => Yii::t('InstallModule.install', 'Step 5 of 8: Installing modules'),
            'createuser'     => Yii::t('InstallModule.install', 'Step 6 of 8: Creating administrator'),
            'sitesettings'   => Yii::t('InstallModule.install', 'Step 7 of 8: Project settings'),
            'finish'         => Yii::t('InstallModule.install', 'Step 8 of 8: Finish'),
        ];
        if (isset($installSteps[$stepName])) {
            return $installSteps[$stepName];
        } else {
            return $installSteps;
        }
    }

    /**
     * Проверка завершённости шага:
     *
     * @param bool|string $actionId - требуемый шаг для проверки
     *
     * @return bool завершён ли шаг
     */
    public function isStepFinished($actionId = false)
    {
        if (!isset(Yii::app()->session['InstallForm'])) {
            Yii::app()->session['InstallForm'] = [];
        }
        $session = Yii::app()->session['InstallForm'];

        if ((isset($session[$actionId . 'Finished'])) && ($session[$actionId . 'Finished'] === true)) {
            return true;
        }
        return false;
    }

    /**
     * Соответствия предыдущих шагов:
     *
     * @return mixed prev steps
     **/
    public function prevSteps()
    {
        return [
            'index'          => 'index',
            'environment'    => 'index',
            'requirements'   => 'environment',
            'dbsettings'     => 'requirements',
            'modulesinstall' => 'dbsettings',
            'createuser'     => 'modulesinstall',
            'sitesettings'   => 'createuser',
            'finish'         => 'sitesettings',
        ];
    }

    /**
     * Соответствия следующих шагов:
     *
     * @return mixed prev steps
     **/
    public function nextSteps()
    {
        return [
            'index'          => 'environment',
            'environment'    => 'requirements',
            'requirements'   => 'dbsettings',
            'dbsettings'     => 'modulesinstall',
            'modulesinstall' => 'createuser',
            'createuser'     => 'sitesettings',
            'sitesettings'   => 'finish',
            'finish'         => 'finish',
        ];
    }

    /**
     * Получаем предыдущий шаг:
     *
     * @param bool|string $actionID - требуемый экшен
     *
     * @return mixed меню
     */
    public function getPrevStep($actionID = false)
    {
        if (!$actionID) {
            $actionID = Yii::app()->controller->action->id;
        }

        $prevSteps = $this->prevSteps();
        if (isset($prevSteps[$actionID])) {
            return $prevSteps[$actionID];
        } else {
            return false;
        }
    }

    /**
     * Получаем следующий шаг:
     *
     * @param bool|string $actionID - требуемый экшен
     *
     * @return mixed меню
     */
    public function getNextStep($actionID = false)
    {
        if (!$actionID) {
            $actionID = Yii::app()->controller->action->id;
        }

        $nextSteps = $this->prevSteps();
        if (isset($nextSteps[$actionID])) {
            return $nextSteps[$actionID];
        } else {
            return false;
        }
    }

    /**
     * Создание навигационного меню для инсталятора:
     *
     * @return mixed меню
     **/
    public function getInstallMenu()
    {
        $installSteps = $this->getInstallSteps();
        $installMenu = [];
        $startUrl = '/' . Yii::app()->controller->module->getId() . '/' . Yii::app()->controller->id . '/';
        foreach ($installSteps as $key => $value) {
            $active = Yii::app()->controller->action->id == $key;

            $installMenu[] = array_merge(
                [
                    'label'  => $value,
                    'icon'   => $active ? 'fa fa-fw fa-arrow-right' : ($this->isStepFinished($key) ? 'fa fa-fw fa-check' : 'fa fa-fw fa-times'),
                    'active' => Yii::app()->controller->action->id == $key,
                ],
                $this->isStepFinished($key) !== true && !$active ? ['disabled' => true, 'url' => false] : ['url' => Yii::app()->createUrl($startUrl . $key)]
            );
        }

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
        return Yii::t('InstallModule.install', 'Yupe!');
    }

    /**
     * Получаем название модуля
     *
     * @return string
     **/
    public function getName()
    {
        return Yii::t('InstallModule.install', 'Installer');
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
        return Yii::t('InstallModule.install', 'Module for system installation');
    }

    /**
     * Версия модуля
     *
     * @return string
     **/
    public function getVersion()
    {
        return Yii::t('InstallModule.install', '0.6');
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
        return "fa fa-fw fa-download";
    }

    /**
     * Инициализация модуля
     *
     * @return nothing
     **/
    public function init()
    {
        $this->setImport(
            [
                'install.forms.*',
                'install.models.*',
                'install.components.*',
            ]
        );
    }

    /**
     * Можно ли включить модуль:
     *
     * @return can activate module
     **/
    public function canActivate()
    {
        return false;
    }
}
