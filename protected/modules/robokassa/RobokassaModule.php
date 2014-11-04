<?php

use yupe\components\WebModule;

class RobokassaModule extends WebModule
{
    const VERSION = '0.9';

    public function getDependencies()
    {
        return array('payment');
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
        return array();
    }

    public function getName()
    {
        return Yii::t('RobokassaModule.robokassa', 'Робокасса');
    }

    public function getDescription()
    {
        return Yii::t('RobokassaModule.robokassa', 'Модуль для приемы оплаты через Робокассу');
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
