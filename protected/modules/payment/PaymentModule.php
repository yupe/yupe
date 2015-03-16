<?php

use yupe\components\WebModule;

class PaymentModule extends WebModule
{
    const VERSION = '0.9.4';

    public $pathAssets = 'payment.views.assets';

    public function getDependencies()
    {
        return ['store'];
    }

    public function getCategory()
    {
        return Yii::t('PaymentModule.payment', 'Store');
    }

    public function getNavigation()
    {
        return [
            ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('PaymentModule.payment', 'Payment methods list'), 'url' => ['/payment/paymentBackend/index']],
            ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('PaymentModule.payment', 'Create payment'), 'url' => ['/payment/paymentBackend/create']],
        ];
    }

    public function getAdminPageLink()
    {
        return '/payment/paymentBackend/index';
    }

    public function getVersion()
    {
        return self::VERSION;
    }

    public function getEditableParams()
    {
        return [];
    }

    public function getName()
    {
        return Yii::t('PaymentModule.payment', 'Payment');
    }

    public function getDescription()
    {
        return Yii::t('PaymentModule.payment', 'Payment orders module');
    }

    public function getAuthor()
    {
        return Yii::t('PaymentModule.payment', 'amylabs team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('PaymentModule.payment', 'hello@amylabs.ru');
    }

    public function getUrl()
    {
        return 'http://amylabs.ru';
    }

    public function getIcon()
    {
        return 'fa fa-fw fa-usd';
    }

    public function init()
    {
        parent::init();

        $this->setImport(
            [
                'payment.models.*',
                'payment.components.payments.*',
                'payment.listeners.*'
            ]
        );
    }

    public function getAuthItems()
    {
        return [
            [
                'type' => AuthItem::TYPE_TASK,
                'name' => 'Payment.PaymentBackend.Management',
                'description' => Yii::t("PaymentModule.payment", 'Manage payment methods'),
                'items' => [
                    ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Payment.PaymentBackend.Index', 'description' => Yii::t("PaymentModule.payment", 'Payment methods list'),],
                    ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Payment.PaymentBackend.Create', 'description' => Yii::t("PaymentModule.payment", 'Create payment'),],
                    ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Payment.PaymentBackend.Update', 'description' => Yii::t("PaymentModule.payment", 'Update payment'),],
                    ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Payment.PaymentBackend.View', 'description' => Yii::t("PaymentModule.payment", 'View payment'),],
                    ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Payment.PaymentBackend.Delete', 'description' => Yii::t("PaymentModule.payment", 'Delete payment'),],
                    ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Payment.PaymentBackend.Multiaction', 'description' => Yii::t("PaymentModule.payment", 'Batch delete'),],
                ],
            ],
        ];
    }
}
