<?php

use yupe\components\WebModule;

/**
 * Class YmlModule
 */
class YmlModule extends WebModule
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
        return Yii::t('YmlModule.default', 'Service');
    }

    /**
     * @return string
     */
    public function getAdminPageLink()
    {
        return '/yml/exportBackend/index';
    }

    /**
     * @return array
     */
    public function getNavigation()
    {
        return [
            [
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('YmlModule.default', 'Export lists'),
                'url' => ['/yml/exportBackend/index'],
            ],
            [
                'icon' => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('YmlModule.default', 'Create export list'),
                'url' => ['/yml/exportBackend/create'],
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
        return Yii::t('YmlModule.default', 'Yml export');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('YmlModule.default', 'Module to export products in the yml file');
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return Yii::t('YmlModule.default', 'amylabs team');
    }

    /**
     * @return string
     */
    public function getAuthorEmail()
    {
        return Yii::t('YmlModule.default', 'hello@amylabs.ru');
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return 'https://yupe.ru';
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
                'application.modules.yml.models.Export',
                'application.modules.store.models.Product',
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
                'description' => Yii::t('YmlModule.default', 'Manage export lists'),
                'items' => [
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'YandexMarket.ExportBackend.Index',
                        'description' => Yii::t('YmlModule.default', 'Export lists'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'YandexMarket.ExportBackend.Create',
                        'description' => Yii::t('YmlModule.default', 'Create export list'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'YandexMarket.ExportBackend.Update',
                        'description' => Yii::t('YmlModule.default', 'Update export list'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'YandexMarket.ExportBackend.View',
                        'description' => Yii::t('YmlModule.default', 'View export list'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'YandexMarket.ExportBackend.Delete',
                        'description' => Yii::t('YmlModule.default', 'Delete export list'),
                    ],
                ],
            ],
        ];
    }
}
