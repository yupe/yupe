<?php
use yupe\components\WebModule;

class DeliveryModule extends WebModule
{
    const VERSION = '0.9.2';

    public function getDependencies()
    {
        return ['store', 'payment'];
    }

    public function getEditableParams()
    {
        return [];
    }

    public function getCategory()
    {
        return Yii::t('DeliveryModule.delivery', 'Store');
    }

    public function getNavigation()
    {
        return [
            ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('DeliveryModule.delivery', 'Список способов доставки'), 'url' => ['/delivery/deliveryBackend/index']],
            ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('DeliveryModule.delivery', 'Добавить способ'), 'url' => ['/delivery/deliveryBackend/create']],
        ];
    }

    public function getAdminPageLink()
    {
        return '/delivery/deliveryBackend/index';
    }

    public function getVersion()
    {
        return self::VERSION;
    }

    public function getName()
    {
        return Yii::t('DeliveryModule.delivery', 'Доставка');
    }

    public function getDescription()
    {
        return Yii::t('DeliveryModule.delivery', 'Модуль для создания способов доставки в интернет-магазине');
    }

    public function getAuthor()
    {
        return Yii::t('DeliveryModule.delivery', 'amylabs team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('DeliveryModule.delivery', 'hello@amylabs.ru');
    }

    public function getUrl()
    {
        return 'http://amylabs.ru';
    }

    public function getIcon()
    {
        return 'fa fa-fw fa-plane';
    }

    public function init()
    {
        parent::init();

        $this->setImport(
            [
                'delivery.models.*',
            ]
        );
    }

    public function getAuthItems()
    {
        return [
            [
                'type' => AuthItem::TYPE_TASK,
                'name' => 'Delivery.DeliveryBackend.Management',
                'description' => Yii::t("StoreModule.store", 'Управление способами доставки'),
                'items' => [
                    ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Delivery.DeliveryBackend.Index', 'description' => Yii::t("DeliveryModule.delivery", 'Просмотр списка способов доставки'),],
                    ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Delivery.DeliveryBackend.Create', 'description' => Yii::t("DeliveryModule.delivery", 'Создание способа доставки'),],
                    ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Delivery.DeliveryBackend.Update', 'description' => Yii::t("DeliveryModule.delivery", 'Редактирование способа доставки'),],
                    ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Delivery.DeliveryBackend.View', 'description' => Yii::t("DeliveryModule.delivery", 'Просмотр способа доставки'),],
                    ['type' => AuthItem::TYPE_OPERATION, 'name' => 'Delivery.DeliveryBackend.Delete', 'description' => Yii::t("DeliveryModule.delivery", 'Удаление способа доставки'),],
                ],
            ],
        ];
    }
}
