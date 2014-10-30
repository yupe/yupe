<?php

use yupe\components\controllers\FrontController;

class CouponController extends FrontController
{
    public function actionAdd()
    {
        if (!Yii::app()->getRequest()->getIsPostRequest()) {
            throw new CHttpException(404);
        }

        $code = strtoupper(Yii::app()->getRequest()->getParam('code'));;
        $result = Yii::app()->cart->couponManager->add($code);
        if (true === $result) {
            Yii::app()->ajax->success(
                Yii::t("CouponModule.coupon", "Купон «{code}» добавлен", array('{code}' => $code))
            );
        } else {
            Yii::app()->ajax->failure($result);
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
            Yii::app()->ajax->success(Yii::t("CouponModule.coupon", "Купон «{code}» удален", array('{code}' => $code)));
        } else {
            Yii::app()->ajax->failure(Yii::t("CouponModule.coupon", 'Купон не найден'));
        }
    }

    public function actionClear()
    {
        if (!Yii::app()->getRequest()->getIsPostRequest()) {
            throw new CHttpException(404);
        }

        Yii::app()->cart->couponManager->clear();
        Yii::app()->ajax->success(Yii::t("CouponModule.coupon", "Купоны удалены"));
    }

    public function actionCoupons()
    {
        Yii::app()->ajax->success(Yii::app()->cart->couponManager->coupons);
    }
} 
