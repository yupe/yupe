<?php

/**
 * Class CouponManager
 */
class CouponManager extends CApplicationComponent
{
    /**
     * @var array
     */
    protected $coupons = [];
    /**
     * @var string
     */
    protected $couponStateKey = 'yupe::store::coupons';

    /**
     *
     */
    public function init()
    {
        $this->coupons = Yii::app()->getUser()->getState($this->couponStateKey, []);
        parent::init();
    }

    /**
     * @return array
     */
    public function getCoupons()
    {
        return $this->coupons;
    }

    /**
     *
     */
    private function saveState()
    {
        Yii::app()->getUser()->setState($this->couponStateKey, $this->coupons);
    }


    public function add(Coupon $coupon)
    {
        $code = mb_strtoupper(trim($coupon->code));

        if (in_array($code, $this->coupons)) {
            return [Yii::t("CouponModule.coupon", 'Coupon already added')];
        }

        $price = Yii::app()->cart->getCost();

        $errors = $coupon->getCouponErrors($price);

        if (empty($errors)) {
            $this->coupons = array_unique(array_merge($this->coupons, [$code]));
            $this->saveState();

            return true;
        }

        return $errors;
    }

    /**
     * @param $code
     */
    public function remove($code)
    {
        $this->coupons = array_diff($this->coupons, [
            mb_strtoupper(trim($code)),
        ]);

        $this->saveState();
    }

    /**
     *
     */
    public function clear()
    {
        $this->coupons = [];
        $this->saveState();
    }

    /**
     *
     */
    public function check()
    {
        if (Yii::app()->cart->isEmpty()) {
            $this->clear();
            return;
        }

        $price = Yii::app()->cart->getCost();
        foreach ($this->coupons as $code) {
            /* @var $coupon Coupon */
            $coupon = $this->findCouponByCode($code);

            if (!$coupon->getIsAvailable($price)) {
                $this->remove($code);
            }
        }
    }

    /**
     * @param $code
     *
     * @return mixed
     */
    public function findCouponByCode($code)
    {
        return Coupon::model()->getCouponByCode(mb_strtoupper(trim($code)));
    }
}
