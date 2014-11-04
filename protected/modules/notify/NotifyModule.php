<?php

use yupe\components\WebModule;

class NotifyModule extends WebModule
{
    const VERSION = '0.9';

    public function getDependencies()
    {
        return array(
            'comment',
            'blog',
            'mail'
        );
    }

	public function init()
	{
        $this->setImport([
                'notify.models.*'
            ]);

		parent::init();
	}

    public function getVersion()
    {
        return self::VERSION;
    }

    public function getCategory()
    {
        return Yii::t('NotifyModule.notify', 'Users');
    }

    public function getName()
    {
        return Yii::t('NotifyModule.notify', 'Notify');
    }

    public function getDescription()
    {
        return Yii::t('NotifyModule.notify', 'Module for user notifications');
    }

    public function getAuthor()
    {
        return Yii::t('NotifyModule.notify', 'amylabs team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('NotifyModule.notify', 'hello@amylabs.ru');
    }

    public function getUrl()
    {
        return Yii::t('NotifyModule.notify', 'http://amylabs.ru');
    }

    public function getIcon()
    {
        return "fa fa-fw fa-paper-plane";
    }


    public function getAdminPageLink()
    {
        return '/notify/notifyBackend/index';
    }

    public function getNavigation()
    {
        return array(
            array(
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('NotifyModule.notify', 'Notify settings'),
                'url'   => array('/notify/notifyBackend/index')
            )
        );
    }
}
