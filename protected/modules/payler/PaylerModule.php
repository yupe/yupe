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

/**
 * Class PaylerModule
 */
class PaylerModule extends WebModule
{
    /**
     *
     */
    const VERSION = '1.0';

    /**
     * @return array
     */
    public function getDependencies()
    {
        return ['payment'];
    }

    /**
     * @return array
     */
    public function getNavigation()
    {
        return [];
    }

    /**
     * @return bool
     */
    public function getAdminPageLink()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function getIsShowInAdminMenu()
    {
        return false;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * @return array
     */
    public function getEditableParams()
    {
        return [];
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return Yii::t('PaylerModule.payler', 'Store');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return Yii::t('PaylerModule.payler', 'Payler');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('PaylerModule.payler', 'Payler payment module');
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return Yii::t('PaylerModule.payler', 'Oleg Filimonov');
    }

    /**
     * @return string
     */
    public function getAuthorEmail()
    {
        return Yii::t('PaylerModule.payler', 'olegsabian@gmail.com');
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return 'https://github.com/sabian/yupe-payler';
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-rub';
    }
}