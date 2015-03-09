<?php

use yupe\components\WebModule;

class PayPalModule extends WebModule
{
    const VERSION = '1';

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
        return Yii::t('PayPalModule.robokassa', 'PayPal');
    }

    public function getDescription()
    {
        return Yii::t('PayPalModule.robokassa', 'Модуль для приемы оплаты через PayPal');
    }

    public function getAuthor()
    {
        return Yii::t('PayPalModule.robokassa', 'AxelPAL');
    }

    public function getAuthorEmail()
    {
        return Yii::t('PayPalModule.robokassa', 'axelpal@gmail.com');
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
