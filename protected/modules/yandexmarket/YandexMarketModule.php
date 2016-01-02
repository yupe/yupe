<?php

use yupe\components\WebModule;

/**
 * Class YandexMarketModule
 */
class YandexMarketModule extends WebModule
{
    /**
     *
     */
    const VERSION = '0.9.9';

    /**
     * @return array
     */
    public function getDependencies()
    {
        return ['store'];
    }

    /**
     * @return array|bool
     */
    public function checkSelf()
    {
        $messages = [];

        return isset($messages[WebModule::CHECK_ERROR]) ? $messages : true;
    }

    /**
     * @return bool
     */
    public function getEditableParams()
    {
        return false;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return Yii::t('YandexMarketModule.default', 'Store');
    }

    /**
     * @return string
     */
    public function getAdminPageLink()
    {
        return '/yandexmarket/exportBackend/index';
    }

    /**
     * @return array
     */
    public function getNavigation()
    {
        return [
            [
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('YandexMarketModule.default', 'Export lists'),
                'url' => ['/yandexmarket/exportBackend/index'],
            ],
            [
                'icon' => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('YandexMarketModule.default', 'Create export list'),
                'url' => ['/yandexmarket/exportBackend/create'],
            ],
        ];
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
    public function getName()
    {
        return Yii::t('YandexMarketModule.default', 'Yandex.Market');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('YandexMarketModule.default', 'Module to export products in the yml file');
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return Yii::t('YandexMarketModule.default', 'amylabs team');
    }

    /**
     * @return string
     */
    public function getAuthorEmail()
    {
        return Yii::t('YandexMarketModule.default', 'hello@amylabs.ru');
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return 'http://yupe.ru';
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-fw fa-upload';
    }

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->setImport(
            [
                'application.modules.yandexmarket.models.*',
                'application.modules.store.models.*',
            ]
        );
    }

    /**
     * @return array
     */
    public function getAuthItems()
    {
        return [
            [
                'type' => AuthItem::TYPE_TASK,
                'name' => 'YandexMarket.ExportBackend.Management',
                'description' => Yii::t('YandexMarketModule.default', 'Manage export lists'),
                'items' => [
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'YandexMarket.ExportBackend.Index',
                        'description' => Yii::t('YandexMarketModule.default', 'Export lists'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'YandexMarket.ExportBackend.Create',
                        'description' => Yii::t('YandexMarketModule.default', 'Create export list'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'YandexMarket.ExportBackend.Update',
                        'description' => Yii::t('YandexMarketModule.default', 'Update export list'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'YandexMarket.ExportBackend.View',
                        'description' => Yii::t('YandexMarketModule.default', 'View export list'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'YandexMarket.ExportBackend.Delete',
                        'description' => Yii::t('YandexMarketModule.default', 'Delete export list'),
                    ],
                ],
            ],
        ];
    }
}
