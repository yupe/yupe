<?php

use yupe\components\WebModule;

/**
 * Class NotifyModule
 */
class NotifyModule extends WebModule
{
    /**
     *
     */
    const VERSION = '1.1';

    /**
     * @return array
     */
    public function getDependencies()
    {
        return [
            'mail',
            'user',
        ];
    }

    /**
     * @return bool
     */
    public function getIsNoDisable()
    {
        return true;
    }

    /**
     *
     */
    public function init()
    {
        $this->setImport(
            [
                'notify.models.*',
            ]
        );

        parent::init();
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return Yii::t('NotifyModule.notify', 'Users');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return Yii::t('NotifyModule.notify', 'Notify');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('NotifyModule.notify', 'Module for user notifications');
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return Yii::t('NotifyModule.notify', 'yupe team');
    }

    /**
     * @return string
     */
    public function getAuthorEmail()
    {
        return Yii::t('NotifyModule.notify', 'support@yupe.ru');
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return Yii::t('NotifyModule.notify', 'http://yupe.ru');
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return "fa fa-fw fa-paper-plane";
    }


    /**
     * @return string
     */
    public function getAdminPageLink()
    {
        return '/notify/notifyBackend/index';
    }

    /**
     * @return array
     */
    public function getNavigation()
    {
        return [
            [
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('NotifyModule.notify', 'Notify settings'),
                'url' => ['/notify/notifyBackend/index'],
            ],
        ];
    }

    /**
     * @return array
     */
    public function getAuthItems()
    {
        return [
            [
                'name' => 'NotifyModule.NotifyManage',
                'description' => Yii::t('NotifyModule.notify', 'Manage notify'),
                'type' => AuthItem::TYPE_TASK,
                'items' => [
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'NotifyModule.NotifyManage.manage',
                        'description' => Yii::t('NotifyModule.notify', 'Manage notify'),
                    ],
                ],
            ],
        ];
    }
}
