<?php

use yupe\components\WebModule;

class PaymentModule extends WebModule
{
    const VERSION = '0.1';

    public $pathAssets = 'payment.views.assets';

    public function getDependencies()
    {
        return array('store');
    }

    public function getCategory()
    {
        return Yii::t('PaymentModule.payment', 'Store');
    }

    public function getNavigation()
    {
        return array(
            array('icon' => 'glyphicon glyphicon-list-alt', 'label' => Yii::t('PaymentModule.payment', 'Список способов оплаты'), 'url' => array('/payment/paymentBackend/index')),
            array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => Yii::t('PaymentModule.payment', 'Добавить способ'), 'url' => array('/payment/paymentBackend/create')),
        );
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
        return array();
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
        return Yii::t('PaymentModule.payment', 'Dark_Cs');
    }

    public function getAuthorEmail()
    {
        return Yii::t('PaymentModule.payment', 'darkcs2@gmail.com');
    }

    public function getIcon()
    {
        return 'glyphicon glyphicon-usd';
    }

    public function init()
    {
        parent::init();

        $this->setImport(
            array(
                'payment.models.*',
                'payment.components.payments.*',
            )
        );
    }

    public function beforeControllerAction($controller, $action)
    {
        $mainAssets = $this->getAssetsUrl();
        if ($controller instanceof \yupe\components\controllers\BackController) {
        } else {
            Yii::app()->clientScript->registerCssFile($mainAssets . '/css/payment-frontend.css');
        }
        return parent::beforeControllerAction($controller, $action);
    }

    public function getAuthItems()
    {
        return array(
            array(
                'type' => AuthItem::TYPE_TASK,
                'name' => 'Payment.PaymentBackend.Management',
                'description' => Yii::t("StoreModule.store", 'Управление способами оплаты'),
                'items' => array(
                    array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Payment.PaymentBackend.Index', 'description' => Yii::t("PaymentModule.payment", 'Просмотр списка способов оплаты'),),
                    array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Payment.PaymentBackend.Create', 'description' => Yii::t("PaymentModule.payment", 'Создание способа оплаты'),),
                    array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Payment.PaymentBackend.Update', 'description' => Yii::t("PaymentModule.payment", 'Редактирование способа оплаты'),),
                    array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Payment.PaymentBackend.View', 'description' => Yii::t("PaymentModule.payment", 'Просмотр способа оплаты'),),
                    array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Payment.PaymentBackend.Delete', 'description' => Yii::t("PaymentModule.payment", 'Удаление способа оплаты'),),
                ),
            ),
        );
    }
}
