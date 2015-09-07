<?php

use yupe\components\WebModule;

class RobokassaModule extends WebModule
{
    const VERSION = '0.9.9';

    public function getDependencies()
    {
        return ['payment'];
    }

    public function getNavigation()
    {
        return false;
    }

    public function getAdminPageLink()
    {
        return false;
    }

    public function getIsShowInAdminMenu()
    {
        return false;
    }

    public function getVersion()
    {
        return self::VERSION;
    }

    public function getEditableParams()
    {
        return [];
    }

    public function getCategory()
    {
        return Yii::t('RobokassaModule.robokassa', 'Store');
    }

    public function getName()
    {
        return Yii::t('RobokassaModule.robokassa', 'Robokassa');
    }

    public function getDescription()
    {
        return Yii::t('RobokassaModule.robokassa', 'Robokassa payment module');
    }

    public function getAuthor()
    {
        return Yii::t('RobokassaModule.robokassa', 'Dark_Cs');
    }

    public function getAuthorEmail()
    {
        return Yii::t('RobokassaModule.robokassa', 'darkcs2@gmail.com');
    }

    public function getIcon()
    {
        return 'fa fa-rub';
    }

    public function init()
    {
        parent::init();
    }
}
