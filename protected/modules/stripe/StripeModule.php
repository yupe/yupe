<?php

use yupe\components\WebModule;

class StripeModule extends WebModule
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
        return Yii::t('StripeModule.stripe', 'Stripe');
    }

    public function getDescription()
    {
        return Yii::t('StripeModule.stripe', 'Module for payment via Stripe');
    }

    public function getAuthor()
    {
        return Yii::t('StripeModule.stripe', 'AxelPAL');
    }

    public function getAuthorEmail()
    {
        return Yii::t('StripeModule.stripe', 'axelpal@gmail.com');
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
