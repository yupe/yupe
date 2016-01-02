<?php

use yupe\components\WebModule;

/**
 * Class OrderModule
 */
class OrderModule extends WebModule
{
    /**
     *
     */
    const VERSION = '0.9.9';

    /**
     * @var
     */
    public $notifyEmailFrom;

    /**
     * @var
     */
    public $notifyEmailsTo;

    /**
     * @var string
     */
    public $assetsPath = 'order.views.assets';

    /**
     * @var int
     */
    public $showOrder = 1;

    /**
     * @var int
     */
    public $enableCheck = 1;

    /**
     * @var int
     */
    public $defaultStatus = 1;

    /**
     * @var int
     */
    public $enableComments = 1;

    /**
     * @return array
     */
    public function getDependencies()
    {
        return ['store', 'payment', 'delivery', 'mail'];
    }

    /**
     * @return array
     */
    public function getEditableParams()
    {
        return [
            'notifyEmailFrom',
            'notifyEmailsTo',
            'showOrder' => $this->getChoice(),
            'enableCheck' => $this->getChoice(),
            'defaultStatus' => CHtml::listData(OrderStatus::model()->findAll(), 'id', 'name'),
            'enableComments' => $this->getChoice(),
        ];
    }

    /**
     * @return array
     */
    public function getParamsLabels()
    {
        return [
            'notifyEmailFrom' => Yii::t('OrderModule.order', 'Notification email'),
            'notifyEmailsTo' => Yii::t('OrderModule.order', 'Recipients of notifications (comma separated)'),
            'showOrder' => Yii::t('OrderModule.order', 'Public ordering page'),
            'enableCheck' => Yii::t('OrderModule.order', 'Allow orders validation by number'),
            'defaultStatus' => Yii::t('OrderModule.order', 'Default order status'),
            'enableComments' => Yii::t('OrderModule.order', 'Allow order comments in admin panel'),
        ];
    }

    /**
     * @return array
     */
    public function getEditableParamsGroups()
    {
        return [
            '0.main' => [
                'label' => Yii::t('OrderModule.order', 'Orders settings'),
                'items' => [
                    'defaultStatus',
                    'showOrder',
                    'enableCheck',
                    'enableComments',
                ],
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

    /**
     * @return string
     */
    public function getCategory()
    {
        return Yii::t('OrderModule.order', 'Store');
    }

    /**
     * @return array
     */
    public function getNavigation()
    {
        return [
            [
                'icon' => 'fa fa-fw fa-users',
                'label' => Yii::t('OrderModule.order', 'Clients'),
                'url' => ['/order/clientBackend/index'],
            ],
            [
                'icon' => 'fa fa-fw fa-gift',
                'label' => Yii::t('OrderModule.order', 'Orders'),
                'url' => ['/order/orderBackend/index'],
            ],
            [
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('OrderModule.order', 'Statuses'),
                'url' => ['/order/statusBackend/index'],
            ],
        ];
    }

    /**
     * @return string
     */
    public function getAdminPageLink()
    {
        return '/order/orderBackend/index';
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
        return Yii::t('OrderModule.order', 'Orders');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('OrderModule.order', 'Orders manage module');
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return Yii::t('OrderModule.order', 'amylabs team');
    }

    /**
     * @return string
     */
    public function getAuthorEmail()
    {
        return Yii::t('OrderModule.order', 'hello@amylabs.ru');
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
        return 'fa fa-fw fa-gift';
    }

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->setImport(
            [
                'order.models.*',
                'order.forms.*',
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
                'name' => 'Order.OrderBackend.Management',
                'description' => Yii::t('OrderModule.order', 'Manage orders'),
                'items' => [
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Order.OrderBackend.Index',
                        'description' => Yii::t('OrderModule.order', 'View order list'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Order.OrderBackend.Create',
                        'description' => Yii::t('OrderModule.order', 'Create order'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Order.OrderBackend.Update',
                        'description' => Yii::t('OrderModule.order', 'Update order'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Order.OrderBackend.View',
                        'description' => Yii::t('OrderModule.order', 'View order'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Order.OrderBackend.Delete',
                        'description' => Yii::t('OrderModule.order', 'Delete order'),
                    ],
                ],
            ],
            [
                'type' => AuthItem::TYPE_TASK,
                'name' => 'Order.StatusBackend.Management',
                'description' => Yii::t('OrderModule.order', 'Manage statuses'),
                'items' => [
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Order.StatusBackend.Index',
                        'description' => Yii::t('OrderModule.order', 'View status list'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Order.StatusBackend.Create',
                        'description' => Yii::t('OrderModule.order', 'Create status'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Order.StatusBackend.Update',
                        'description' => Yii::t('OrderModule.order', 'Update status'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Order.StatusBackend.Delete',
                        'description' => Yii::t('OrderModule.order', 'Delete status'),
                    ],
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function getNotifyTo()
    {
        return explode(',', $this->notifyEmailsTo);
    }
}
