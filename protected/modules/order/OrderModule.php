<?php

use yupe\components\WebModule;

class OrderModule extends WebModule
{
    const VERSION = '0.9.3';

    public $notifyEmailFrom;

    public $notifyEmailsTo;

    public $assetsPath = "order.views.assets";

    public $showOrder = 1;

    public $enableCheck = 1;

    public function getDependencies()
    {
        return ['store', 'payment', 'delivery', 'mail'];
    }

    public function getEditableParams()
    {
        return [
            'notifyEmailFrom',
            'notifyEmailsTo',
            'showOrder'   => $this->getChoice(),
            'enableCheck' => $this->getChoice()
        ];
    }

    public function getParamsLabels()
    {
        return [
            'notifyEmailFrom' => Yii::t('OrderModule.order', 'Notification email'),
            'notifyEmailsTo'  => Yii::t('OrderModule.order', 'Recipients of notifications (comma separated)'),
            'showOrder'       => Yii::t('OrderModule.order', 'Public ordering page'),
            'enableCheck'     => Yii::t('OrderModule.order', 'Allow orders validation by number'),
        ];
    }

    public function getEditableParamsGroups()
    {
        return [
            '0.main' => [
                'label' => Yii::t('OrderModule.order', 'Orders settings'),
                'items' => [
                    'showOrder',
                    'enableCheck'
                ]
            ],
            '1.notify' => [
                'label' => Yii::t('OrderModule.order', 'Notifications'),
                'items' => [
                    'notifyEmailFrom',
                    'notifyEmailsTo',
                ],
            ],
        ];
    }

    public function getCategory()
    {
        return Yii::t('OrderModule.order', 'Store');
    }

    public function getNavigation()
    {
        return [
            ['icon' => 'fa fa-fw fa-gift', 'label' => Yii::t('OrderModule.order', 'Orders'), 'url' => ['/order/orderBackend/index']],
        ];
    }

    public function getAdminPageLink()
    {
        return '/order/orderBackend/index';
    }

    public function getVersion()
    {
        return self::VERSION;
    }

    public function getName()
    {
        return Yii::t('OrderModule.order', 'Orders');
    }

    public function getDescription()
    {
        return Yii::t('OrderModule.order', 'Orders manage module');
    }

    public function getAuthor()
    {
        return Yii::t('OrderModule.order', 'amylabs team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('OrderModule.order', 'hello@amylabs');
    }

    public function getUrl()
    {
        return 'http://amylabs.ru';
    }

    public function getIcon()
    {
        return 'fa fa-fw fa-gift';
    }

    public function init()
    {
        parent::init();

        $this->setImport(
            [
                'order.models.*',
                'order.forms.*'
            ]
        );
    }

    public function getAuthItems()
    {
        return [
            [
                'type' => AuthItem::TYPE_TASK,
                'name' => 'Order.OrderBackend.Management',
                'description' => 'Управление заказами',
                'items' => [
                    ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Order.OrderBackend.Index', 'description' => Yii::t("OrderModule.order", 'Просмотр списка заказов'),],
                    ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Order.OrderBackend.Create', 'description' => Yii::t("OrderModule.order", 'Создание заказа'),],
                    ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Order.OrderBackend.Update', 'description' => Yii::t("OrderModule.order", 'Редактирование заказа'),],
                    ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Order.OrderBackend.View', 'description' => Yii::t("OrderModule.order", 'Просмотр заказа'),],
                    ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Order.OrderBackend.Delete', 'description' => Yii::t("OrderModule.order", 'Удаление заказа'),],
                ],
            ],
        ];
    }

    public function getNotifyTo()
    {
        return explode(',', $this->notifyEmailsTo);
    }
}
