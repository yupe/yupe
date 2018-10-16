<?php

use yupe\widgets\YFlashMessages;
use yupe\components\controllers\FrontController;

/**
 * Class CouponController
 */
class CouponController extends FrontController
{
    /**
     * @var CouponManager
     */
    protected $couponManager;

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->couponManager = Yii::app()->cart->couponManager;
    }

    /**
     * @return array
     */
    public function filters()
    {
        return [
            'postOnly'
        ];
    }

    /**
     * @throws CHttpException
     */
    public function actionAdd()
    {
        if (!Yii::app()->getRequest()->getParam('code')) {
            throw new CHttpException(404);
        }

        $coupon = $this->couponManager->findCouponByCode(Yii::app()->getRequest()->getParam('code'));

        if (null === $coupon) {
            if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                Yii::app()->ajax->failure([Yii::t("CouponModule.coupon", 'Coupon not found')]);
            } else {
                Yii::app()->getUser()->setFlash(YFlashMessages::ERROR_MESSAGE, Yii::t("CouponModule.coupon", 'Coupon not found'));
                $this->refresh();
            }
        }

        $result = $this->couponManager->add($coupon);

        if (true === $result) {
            Yii::app()->ajax->success(
                Yii::t("CouponModule.coupon", "Coupon «{code}» added", ['{code}' => $coupon->code])
            );
        } else {
            if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                Yii::app()->ajax->failure($result);
            } else {
                Yii::app()->getUser()->setFlash(YFlashMessages::ERROR_MESSAGE, implode(' ', $result));
                $this->refresh();
            }
        }
    }

    /**
     * @throws CHttpException
     */
    public function actionRemove()
    {
        $code = strtoupper(Yii::app()->getRequest()->getParam('code'));

        if ($code) {
            $this->couponManager->remove($code);
            Yii::app()->ajax->success(Yii::t("CouponModule.coupon", "Coupon «{code}» deleted", ['{code}' => $code]));
        } else {
            Yii::app()->ajax->failure(Yii::t("CouponModule.coupon", 'Coupon not found'));
        }
    }

    /**
     * @throws CHttpException
     */
    public function actionClear()
    {
        $this->couponManager->clear();
        Yii::app()->ajax->success(Yii::t("CouponModule.coupon", "Coupons are deleted"));
    }

    /**
     *
     */
    public function actionCoupons()
    {
        Yii::app()->ajax->success(Yii::app()->cart->couponManager->coupons);
    }
} 
