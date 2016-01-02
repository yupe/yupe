<?php

use yupe\components\WebModule;

/**
 * Class PaymentModule
 */
class PaymentModule extends WebModule
{
    /**
     *
     */
    const VERSION = '0.9.9';

    /**
     * @var string
     */
    public $pathAssets = 'payment.views.assets';

    /**
     * @return array
     */
    public function getDependencies()
    {
        return ['store'];
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return Yii::t('PaymentModule.payment', 'Store');
    }

    /**
     * @return array
     */
    public function getNavigation()
    {
        return [
            [
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('PaymentModule.payment', 'Payment methods list'),
                'url' => ['/payment/paymentBackend/index'],
            ],
            [
                'icon' => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('PaymentModule.payment', 'Create payment'),
                'url' => ['/payment/paymentBackend/create'],
            ],
        ];
    }

    /**
     * @return string
     */
    public function getAdminPageLink()
    {
        return '/payment/paymentBackend/index';
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
    public function getName()
    {
        return Yii::t('PaymentModule.payment', 'Payment');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('PaymentModule.payment', 'Payment orders module');
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return Yii::t('PaymentModule.payment', 'amylabs team');
    }

    /**
     * @return string
     */
    public function getAuthorEmail()
    {
        return Yii::t('PaymentModule.payment', 'hello@amylabs.ru');
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
        return 'fa fa-fw fa-usd';
    }

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->setImport(
            [
                'payment.models.*',
                'payment.components.payments.*',
                'payment.listeners.*',
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
                'name' => 'Payment.PaymentBackend.Management',
                'description' => Yii::t('PaymentModule.payment', 'Manage payment methods'),
                'items' => [
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Payment.PaymentBackend.Index',
                        'description' => Yii::t('PaymentModule.payment', 'Payment methods list'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Payment.PaymentBackend.Create',
                        'description' => Yii::t('PaymentModule.payment', 'Create payment'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Payment.PaymentBackend.Update',
                        'description' => Yii::t('PaymentModule.payment', 'Update payment'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Payment.PaymentBackend.View',
                        'description' => Yii::t('PaymentModule.payment', 'View payment'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Payment.PaymentBackend.Delete',
                        'description' => Yii::t('PaymentModule.payment', 'Delete payment'),
                    ],
                ],
            ],
        ];
    }
}
