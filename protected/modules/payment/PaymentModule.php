<?php

use yupe\components\WebModule;

class PaymentModule extends WebModule
{
    const VERSION = '0.9.2';

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
            ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('PaymentModule.payment', 'Список способов оплаты'), 'url' => ['/payment/paymentBackend/index']],
            ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('PaymentModule.payment', 'Добавить способ'), 'url' => ['/payment/paymentBackend/create']],
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
        return Yii::t('PaymentModule.payment', 'Оплата');
    }

    public function getDescription()
    {
        return Yii::t('PaymentModule.payment', 'Модуль для приемы оплаты заказов');
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
                'description' => Yii::t("StoreModule.store", 'Управление способами оплаты'),
                'items' => [
                    ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Payment.PaymentBackend.Index', 'description' => Yii::t("PaymentModule.payment", 'Просмотр списка способов оплаты'),],
                    ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Payment.PaymentBackend.Create', 'description' => Yii::t("PaymentModule.payment", 'Создание способа оплаты'),],
                    ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Payment.PaymentBackend.Update', 'description' => Yii::t("PaymentModule.payment", 'Редактирование способа оплаты'),],
                    ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Payment.PaymentBackend.View', 'description' => Yii::t("PaymentModule.payment", 'Просмотр способа оплаты'),],
                    ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Payment.PaymentBackend.Delete', 'description' => Yii::t("PaymentModule.payment", 'Удаление способа оплаты'),],
                ],
            ],
        ];
    }
}
