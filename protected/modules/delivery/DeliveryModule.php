<?php
use yupe\components\WebModule;

/**
 * Class DeliveryModule
 */
class DeliveryModule extends WebModule
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
        return ['store', 'payment'];
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
        return Yii::t('DeliveryModule.delivery', 'Store');
    }

    /**
     * @return array
     */
    public function getNavigation()
    {
        return [
            [
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('DeliveryModule.delivery', 'Delivery lists'),
                'url' => ['/delivery/deliveryBackend/index'],
            ],
            [
                'icon' => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('DeliveryModule.delivery', 'Create delivery'),
                'url' => ['/delivery/deliveryBackend/create'],
            ],
        ];
    }

    /**
     * @return string
     */
    public function getAdminPageLink()
    {
        return '/delivery/deliveryBackend/index';
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
        return Yii::t('DeliveryModule.delivery', 'Delivery');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('DeliveryModule.delivery', 'Delivery module');
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return Yii::t('DeliveryModule.delivery', 'amylabs team');
    }

    /**
     * @return string
     */
    public function getAuthorEmail()
    {
        return Yii::t('DeliveryModule.delivery', 'hello@amylabs.ru');
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
        return 'fa fa-fw fa-car';
    }

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->setImport(
            [
                'delivery.models.*',
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
                'name' => 'Delivery.DeliveryBackend.Management',
                'description' => Yii::t('DeliveryModule.delivery', 'Manage delivery methods'),
                'items' => [
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Delivery.DeliveryBackend.Index',
                        'description' => Yii::t('DeliveryModule.delivery', 'Delivery lists'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Delivery.DeliveryBackend.Create',
                        'description' => Yii::t('DeliveryModule.delivery', 'Create delivery'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Delivery.DeliveryBackend.Update',
                        'description' => Yii::t('DeliveryModule.delivery', 'Update delivery'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Delivery.DeliveryBackend.View',
                        'description' => Yii::t('DeliveryModule.delivery', 'View delivery'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Delivery.DeliveryBackend.Delete',
                        'description' => Yii::t('DeliveryModule.delivery', 'Delete delivery'),
                    ],
                ],
            ],
        ];
    }
}
