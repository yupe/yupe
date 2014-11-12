<?php

/**
 * MetrikaModule основной класс модуля metrika
 *
 * @author apexwire <apexwire@amylabs.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.metrika
 * @since 0.1
 *
 */

use yupe\components\WebModule;

class MetrikaModule extends WebModule
{
    const VERSION = '0.1';

    public $perPage  = 10;

    public function getVersion()
    {
        return self::VERSION;
    }

    public function getIsInstallDefault()
    {
        return true;
    }

    public function getCategory()
    {
        return Yii::t('YupeModule.yupe', 'Services');
    }

    public function getName()
    {
        return Yii::t('MetrikaModule.metrika', 'Metrika');
    }

    public function getDescription()
    {
        return Yii::t('MetrikaModule.metrika', 'Accounting module for Web Navigation');
    }

    public function getAuthor()
    {
        return Yii::t('MetrikaModule.metrika', 'apexwire');
    }

    public function getAuthorEmail()
    {
        return Yii::t('MetrikaModule.metrika', 'apexwire@amylabs.ru');
    }

    public function getUrl()
    {
        return Yii::t('YupeModule.yupe', 'http://yupe.ru');
    }

    public function getIcon()
    {
        return "glyphicon glyphicon-list";
    }

    public function getAdminPageLink()
    {
        return '/metrika/metrikaBackend/index';
    }

    public function getNavigation()
    {
        return array(
            array('icon' => 'glyphicon glyphicon-list', 'label' => Yii::t('MetrikaModule.metrika', 'List of links'), 'url' => array('/metrika/metrikaBackend/index')),
            array('icon' => 'glyphicon glyphicon-list', 'label' => Yii::t('MetrikaModule.metrika', 'List of transitions'), 'url' => array('/metrika/metrikaBackend/transitions')),
        );
    }

    public function init()
    {
        parent::init();

        $this->setImport(array(
            'metrika.models.*'            
        ));
    }
}