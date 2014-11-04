<?php

use yupe\components\WebModule;

class CouponModule extends WebModule
{
    const VERSION = '0.9';

    public function getDependencies()
    {
        return array('cart');
    }

    public function getEditableParams()
    {
        return array();
    }

    public function getNavigation()
    {
        return array(
            array(
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('CouponModule.coupon', 'Список купонов'),
                'url' => array('/coupon/couponBackend/index')
            ),
            array(
                'icon' => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('CouponModule.coupon', 'Добавить купон'),
                'url' => array('/coupon/couponBackend/create')
            ),

        );
    }

    public function getAdminPageLink()
    {
        return '/coupon/couponBackend/index';
    }

    public function getVersion()
    {
        return self::VERSION;
    }

    public function getCategory()
    {
        return Yii::t('CouponModule.coupon', 'Store');
    }

    public function getName()
    {
        return Yii::t('CouponModule.coupon', 'Купоны');
    }

    public function getDescription()
    {
        return Yii::t('CouponModule.coupon', 'Купоны для заказов в интернет-магазине');
    }

    public function getAuthor()
    {
        return Yii::t('CouponModule.coupon', 'amylabs team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('CouponModule.coupon', 'hello@amylabs.ru');
    }

    public function getUrl()
    {
        return 'http://amylabs.ru';
    }

    public function getIcon()
    {
        return 'fa fa-fw fa-tags';
    }

    public function init()
    {
        parent::init();

        $this->setImport(
            array(
                'coupon.models.*',
            )
        );
    }

    public function getAuthItems()
    {
        return array(
            array(
                'type' => AuthItem::TYPE_TASK,
                'name' => 'Coupon.CouponBackend.Management',
                'description' => Yii::t("StoreModule.store", 'Управление купонами'),
                'items' => array(
                    array(
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Coupon.CouponBackend.Index',
                        'description' => Yii::t("StoreModule.store", 'Просмотр списка купонов'),
                    ),
                    array(
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Coupon.CouponBackend.Create',
                        'description' => Yii::t("StoreModule.store", 'Создание купона'),
                    ),
                    array(
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Coupon.CouponBackend.Update',
                        'description' => Yii::t("StoreModule.store", 'Редактирование купона'),
                    ),
                    array(
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Coupon.CouponBackend.View',
                        'description' => Yii::t("StoreModule.store", 'Просмотр купона'),
                    ),
                    array(
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Coupon.CouponBackend.Delete',
                        'description' => Yii::t("StoreModule.store", 'Удаление купона'),
                    ),
                ),
            ),
        );
    }
}
