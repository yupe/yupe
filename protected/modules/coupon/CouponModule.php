<?php

use yupe\components\WebModule;

/**
 * Class CouponModule
 */
class CouponModule extends WebModule
{
    /**
     *
     */
    const VERSION = '0.9.9';

    public function getDependencies()
    {
        return ['order'];
    }

    /**
     * @return array
     */
    public function getEditableParams()
    {
        return [];
    }

    /**
     * @return array
     */
    public function getNavigation()
    {
        return [
            [
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('CouponModule.coupon', 'Coupons list'),
                'url' => ['/coupon/couponBackend/index']
            ],
            [
                'icon' => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('CouponModule.coupon', 'Create coupon'),
                'url' => ['/coupon/couponBackend/create']
            ],

        ];
    }

    /**
     * @return string
     */
    public function getAdminPageLink()
    {
        return '/coupon/couponBackend/index';
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
    public function getCategory()
    {
        return Yii::t('CouponModule.coupon', 'Store');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return Yii::t('CouponModule.coupon', 'Coupons');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('CouponModule.coupon', 'Store coupon module');
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return Yii::t('CouponModule.coupon', 'amylabs team');
    }

    /**
     * @return string
     */
    public function getAuthorEmail()
    {
        return Yii::t('CouponModule.coupon', 'hello@amylabs.ru');
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
        return 'fa fa-fw fa-tags';
    }

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->setImport(
            [
                'coupon.models.*',
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
                'name' => 'Coupon.CouponBackend.Management',
                'description' => Yii::t('CouponModule.coupon', 'Manage coupons'),
                'items' => [
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Coupon.CouponBackend.Index',
                        'description' => Yii::t('CouponModule.coupon', 'Coupons list'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Coupon.CouponBackend.Create',
                        'description' => Yii::t('CouponModule.coupon', 'Create coupon'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Coupon.CouponBackend.Update',
                        'description' => Yii::t('CouponModule.coupon', 'Update coupon'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Coupon.CouponBackend.View',
                        'description' => Yii::t('CouponModule.coupon', 'View coupon'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Coupon.CouponBackend.Delete',
                        'description' => Yii::t('CouponModule.coupon', 'Delete coupon'),
                    ],
                ],
            ],
        ];
    }
}
