<?php
/**
 * Payler payment module
 *
 * @package  yupe.modules.payler
 * @author   Oleg Filimonov <olegsabian@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     https://github.com/sabian/yupe-payler
 **/

use yupe\components\WebModule;

class PaylerModule extends WebModule
{
    const VERSION = '1.0.1';

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
        return Yii::t('PaylerModule.payler', 'Store');
    }

    public function getName()
    {
        return Yii::t('PaylerModule.payler', 'Payler');
    }

    public function getDescription()
    {
        return Yii::t('PaylerModule.payler', 'Payler payment module');
    }

    public function getAuthor()
    {
        return Yii::t('PaylerModule.payler', 'Oleg Filimonov');
    }

    public function getAuthorEmail()
    {
        return Yii::t('PaylerModule.payler', 'olegsabian@gmail.com');
    }

    public function getUrl()
    {
        return 'https://github.com/sabian/yupe-payler';
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