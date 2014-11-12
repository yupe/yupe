<?php

use yupe\components\WebModule;

class OrderModule extends WebModule
{
    const VERSION = '0.9';

    public $notifyEmailFrom;
    public $notifyEmailsTo;

    public $assetsPath = "order.views.assets";

    public function getDependencies()
    {
        return array('store', 'payment', 'delivery', 'mail');
    }

    public function getEditableParams()
    {
        return array(
            'notifyEmailFrom',
            'notifyEmailsTo',
        );
    }

    public function getParamsLabels()
    {
        return array(
            'notifyEmailFrom' => Yii::t('OrderModule.order', 'Email, от имени которого отправлять оповещения'),
            'notifyEmailsTo' => Yii::t('OrderModule.order', 'Получатели оповещений (через запятую)'),
        );
    }

    public function getEditableParamsGroups()
    {
        return array(
            '0.notify' => array(
                'label' => Yii::t('OrderModule.order', 'Оповещения'),
                'items' => array(
                    'notifyEmailFrom',
                    'notifyEmailsTo',
                ),
            ),
        );
    }

    public function getCategory()
    {
        return Yii::t('OrderModule.order', 'Store');
    }

    public function getNavigation()
    {
        return array(
            array('icon' => 'fa fa-fw fa-gift', 'label' => Yii::t('OrderModule.order', 'Заказы'), 'url' => array('/order/orderBackend/index')),
        );
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
        return Yii::t('OrderModule.order', 'Заказы');
    }

    public function getDescription()
    {
        return Yii::t('OrderModule.order', 'Модуль для управления заказами');
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
            array(
                'order.models.*'
            )
        );
    }

    public function getAuthItems()
    {
        return array(
            array(
                'type' => AuthItem::TYPE_TASK,
                'name' => 'Order.OrderBackend.Management',
                'description' => 'Управление заказами',
                'items' => array(
                    array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Order.OrderBackend.Index', 'description' => Yii::t("OrderModule.order", 'Просмотр списка заказов'),),
                    array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Order.OrderBackend.Create', 'description' => Yii::t("OrderModule.order", 'Создание заказа'),),
                    array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Order.OrderBackend.Update', 'description' => Yii::t("OrderModule.order", 'Редактирование заказа'),),
                    array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Order.OrderBackend.View', 'description' => Yii::t("OrderModule.order", 'Просмотр заказа'),),
                    array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Order.OrderBackend.Delete', 'description' => Yii::t("OrderModule.order", 'Удаление заказа'),),
                ),
            ),
        );
    }

    public function getNotifyTo()
    {
        return explode(',', $this->notifyEmailsTo);
    }
}
