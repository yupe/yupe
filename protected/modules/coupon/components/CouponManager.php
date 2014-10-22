<?php

class CouponManager extends CComponent
{
    private $coupons = array();
    private $couponStateKey = 'cart_coupons';

    public function __construct()
    {
        $this->restoreFromSession();
    }

    public function getCoupons()
    {
        return $this->coupons;
    }

    private function restoreFromSession()
    {
        $this->coupons = Yii::app()->getUser()->getState($this->couponStateKey, array());
    }

    private function saveState()
    {
        Yii::app()->getUser()->setState($this->couponStateKey, $this->coupons);
    }

    /**
     * @param $code - Код купона
     * @return bool|array - true - в случае успешного добавления, array - список ошибок
     */
    public function add($code)
    {
        $code = strtoupper($code);
        if (in_array($code, $this->coupons)) {
            return array(Yii::t("CouponManager.coupon", 'Купон уже добавлен'));
        }
        /* @var $coupon Coupon */
        $coupon = Coupon::model()->getCouponByCode($code);
        if ($coupon) {
            $price = Yii::app()->cart->getCost();
            if ($coupon->getIsAvailable($price)) {
                $this->coupons = array_unique(array_merge($this->coupons, array($code)));
                $this->saveState();
                return true;
            } else {
                return $coupon->getCouponErrors($price);
            }
        } else {
            return array(Yii::t("CouponManager.coupon", 'Купон не найден'));
        }
    }

    public function remove($code)
    {
        $code = strtoupper($code);
        $this->coupons = array_diff($this->coupons, array($code));
        $this->saveState();
    }

    public function clear()
    {
        $this->coupons = array();
        $this->saveState();
    }

    public function check()
    {
        if (Yii::app()->cart->isEmpty()) {
            $this->clear();
            return;
        }
        $price = Yii::app()->cart->getCost();
        foreach ($this->coupons as $code) {
            /* @var $coupon Coupon */
            $coupon = Coupon::model()->getCouponByCode($code);
            if (!$coupon->getIsAvailable($price)) {
                $this->remove($code);
            }
        }
    }
}
