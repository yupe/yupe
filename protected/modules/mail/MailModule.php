<?php
/**
 * MailModule основной класс модуля install
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.mail
 * @since 0.1
 *
 */

class MailModule extends yupe\components\WebModule
{
    /**
     * Метод получения версии:
     *
     * @return string version
     **/
    public function getVersion()
    {
        return Yii::t('MailModule.mail', '0.6');
    }

    /**
     * Метод получения категории:
     *
     * @return string category
     **/
    public function getCategory()
    {
        return Yii::t('MailModule.mail', 'Services');
    }

    /**
     * Метод получения названия модуля:
     *
     * @return string name
     **/
    public function getName()
    {
        return Yii::t('MailModule.mail', 'Mail messages');
    }

    /**
     * Метод получения описвния модуля:
     *
     * @return string description
     **/
    public function getDescription()
    {
        return Yii::t('MailModule.mail', 'Module for mail message management');
    }

    /**
     * Метод получения автора модуля:
     *
     * @return string author
     **/
    public function getAuthor()
    {
        return Yii::t('MailModule.mail', 'yupe team');
    }

    /**
     * Метод получения почты автора модуля:
     *
     * @return string author mail
     **/
    public function getAuthorEmail()
    {
        return Yii::t('MailModule.mail', 'team@yupe.ru');
    }

    /**
     * Метод получения ссылки на сайт автора модуля:
     *
     * @return string author url
     **/
    public function getUrl()
    {
        return Yii::t('MailModule.mail', 'http://yupe.ru');
    }

    /**
     * Метод получения иконки:
     *
     * @return string icon
     **/
    public function getIcon()
    {
        return 'envelope';
    }

    /**
     * Метод получения адреса модуля в админ панели:
     *
     * @return string admin url
     **/
    public function getAdminPageLink()
    {
        return '/mail/eventBackend/index';
    }

    /**
     * Метод получения меню модуля (для навигации):
     *
     * @return mixed navigation of module
     **/
    public function getNavigation()
    {
        return array(
            array('label' => Yii::t('MailModule.mail', 'Mail events')),
            array('icon' => 'list-alt', 'label' => Yii::t('MailModule.mail', 'Messages list'), 'url'=>array('/mail/eventBackend/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('MailModule.mail', 'Create event'), 'url' => array('/mail/eventBackend/create')),
            array('label' => Yii::t('MailModule.mail', 'Mail templates')),
            array('icon'=> 'list-alt', 'label' => Yii::t('MailModule.mail', 'Templates list'), 'url'=>array('/mail/templateBackend/index')),
            array('icon'=> 'plus-sign', 'label' => Yii::t('MailModule.mail', 'Create template'), 'url' => array('/mail/templateBackend/create')),
        );
    }

    /**
     * Метод инициализации модуля:
     *
     * @return nothing
     **/
    public function init()
    {
        $this->setImport(
            array(
                'mail.models.*',
                'mail.components.*',
            )
        );

        parent::init();
    }

    /**
     * Получаем массив с именами модулей, от которых зависит работа данного модуля
     * 
     * @return array Массив с именами модулей, от которых зависит работа данного модуля
     * 
     * @since 0.5
     */
    public function getDependencies()
    {
        return array('user');
    }
}