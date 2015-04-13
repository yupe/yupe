<?php

use yupe\components\WebModule;

class YandexMarketModule extends WebModule
{
    const VERSION = '0.9.1';

    public function getDependencies()
    {
        return ['store'];
    }

    public function checkSelf()
    {
        $messages = [];

        return isset($messages[WebModule::CHECK_ERROR]) ? $messages : true;
    }

    public function getEditableParams()
    {
        return false;
    }

    public function getCategory()
    {
        return Yii::t('YandexMarketModule.default', 'Store');
    }

    public function getAdminPageLink()
    {
        return '/yandexmarket/exportBackend/index';
    }

    public function getNavigation()
    {
        return [
            ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('YandexMarketModule.default', 'Export lists'), 'url' => ['/yandexmarket/exportBackend/index']],
            ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('YandexMarketModule.default', 'Create export list'), 'url' => ['/yandexmarket/exportBackend/create']]
        ];
    }

    public function getVersion()
    {
        return self::VERSION;
    }

    public function getName()
    {
        return Yii::t('YandexMarketModule.default', 'Yandex.Market');
    }

    public function getDescription()
    {
        return Yii::t('YandexMarketModule.default', 'Module to export products in the yml file');
    }

    public function getAuthor()
    {
        return Yii::t('YandexMarketModule.default', 'amylabs team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('YandexMarketModule.default', 'hello@amylabs.ru');
    }

    public function getUrl()
    {
        return 'http://amylabs.ru';
    }

    public function getIcon()
    {
        return 'fa fa-fw fa-upload';
    }

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

    public function getAuthItems()
    {
        return [
            [
                'type' => AuthItem::TYPE_TASK,
                'name' => 'YandexMarket.ExportBackend.Management',
                'description' => Yii::t("YandexMarketModule.default", 'Manage export lists'),
                'items' => [
                    ['type' => AuthItem::TYPE_OPERATION, 'name' => 'YandexMarket.ExportBackend.Index', 'description' => Yii::t("YandexMarketModule.default", 'Export lists'),],
                    ['type' => AuthItem::TYPE_OPERATION, 'name' => 'YandexMarket.ExportBackend.Create', 'description' => Yii::t("YandexMarketModule.default", 'Create export list'),],
                    ['type' => AuthItem::TYPE_OPERATION, 'name' => 'YandexMarket.ExportBackend.Update', 'description' => Yii::t("YandexMarketModule.default", 'Update export list'),],
                    ['type' => AuthItem::TYPE_OPERATION, 'name' => 'YandexMarket.ExportBackend.View', 'description' => Yii::t("YandexMarketModule.default", 'View export list'),],
                    ['type' => AuthItem::TYPE_OPERATION, 'name' => 'YandexMarket.ExportBackend.Delete', 'description' => Yii::t("YandexMarketModule.default", 'Delete export list'),],
                    ['type' => AuthItem::TYPE_OPERATION, 'name' => 'YandexMarket.ExportBackend.Multiaction', 'description' => Yii::t("YandexMarketModule.default", 'Batch delete'),],
                ],
            ],
        ];
    }
}
