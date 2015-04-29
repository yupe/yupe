<?php

class CouponController extends \yupe\components\controllers\FrontController
{
    public function actionAdd()
    {
        if (!Yii::app()->getRequest()->getIsPostRequest() || !Yii::app()->getRequest()->getParam('code')) {
            throw new CHttpException(404);
        }

        $code = Yii::app()->getRequest()->getParam('code');

        if (true === Yii::app()->cart->couponManager->add($code)) {
            Yii::app()->ajax->success(
                Yii::t("CouponModule.coupon", "Coupon «{code}» added", ['{code}' => $code])
            );
        }

        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            Yii::app()->ajax->failure([Yii::t("CouponModule.coupon", 'Coupon not found')]);
        }
    }

    public function actionRemove()
    {
        if (!Yii::app()->getRequest()->getIsPostRequest()) {
            throw new CHttpException(404);
        }

        $code = strtoupper(Yii::app()->getRequest()->getParam('code'));
        if ($code) {
            Yii::app()->cart->couponManager->remove($code);
            Yii::app()->ajax->success(Yii::t("CouponModule.coupon", "Coupon «{code}» deleted", ['{code}' => $code]));
        } else {
            Yii::app()->ajax->failure(Yii::t("CouponModule.coupon", 'Coupon not found'));
        }
    }

    public function actionClear()
    {
        if (!Yii::app()->getRequest()->getIsPostRequest()) {
            throw new CHttpException(404);
        }

        Yii::app()->cart->couponManager->clear();
        Yii::app()->ajax->success(Yii::t("CouponModule.coupon", "Coupons are deleted"));
    }

    public function actionCoupons()
    {
        Yii::app()->ajax->success(Yii::app()->cart->couponManager->coupons);
    }
} 
