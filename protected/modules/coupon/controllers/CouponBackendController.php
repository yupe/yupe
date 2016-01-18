<?php

class CouponBackendController extends yupe\components\controllers\BackController
{
    public function actions()
    {
        return [
            'inline' => [
                'class' => 'yupe\components\actions\YInLineEditAction',
                'model' => 'Coupon',
                'validAttributes' => [
                    'status',
                ],
            ],
        ];
    }

    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin'],],
            ['allow', 'actions' => ['index'], 'roles' => ['Coupon.CouponBackend.Index'],],
            ['allow', 'actions' => ['view'], 'roles' => ['Coupon.CouponBackend.View'],],
            ['allow', 'actions' => ['create'], 'roles' => ['Coupon.CouponBackend.Create'],],
            ['allow', 'actions' => ['update', 'inline'], 'roles' => ['Coupon.CouponBackend.Update'],],
            ['allow', 'actions' => ['delete', 'multiaction'], 'roles' => ['Coupon.CouponBackend.Delete'],],
            ['deny',],
        ];
    }

    public function actionView($id)
    {
        $this->render('view', ['model' => $this->loadModel($id)]);
    }

    public function actionCreate()
    {
        $model = new Coupon();
        $attributes = Yii::app()->getRequest()->getPost('Coupon');

        if ($attributes) {
            $model->attributes = $attributes;

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('CouponModule.coupon', 'Record created!')
                );

                $submitType = Yii::app()->getRequest()->getPost('submit-type');

                if ($submitType) {
                    $this->redirect([$submitType]);
                }

                $this->redirect(['update', 'id' => $model->id]);
            }
        }

        $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $attributes = Yii::app()->getRequest()->getPost('Coupon');

        if ($attributes) {
            $model->attributes = $attributes;

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('CouponModule.coupon', 'Record updated!')
                );

                $submitType = Yii::app()->getRequest()->getPost('submit-type');

                if ($submitType) {
                    $this->redirect([$submitType]);
                }

                $this->redirect(['update', 'id' => $model->id]);
            }
        }

        $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        if (!Yii::app()->getRequest()->getIsPostRequest()) {
            throw new CHttpException(400, Yii::t('CouponModule.coupon', 'Unknown request. Don\'t repeat it please!'));
        }

        $this->loadModel($id)->delete();

        Yii::app()->user->setFlash(
            yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
            Yii::t('CouponModule.coupon', 'Record removed!')
        );

        if (!Yii::app()->getRequest()->getQuery('ajax')) {
            $this->redirect(Yii::app()->getRequest()->getPost('returnUrl', ['index']));
        }
    }


    public function actionIndex()
    {
        $model = new Coupon('search');
        $attributes = Yii::app()->getRequest()->getQuery('Coupon');

        $model->unsetAttributes();

        if ($attributes) {
            $model->attributes = $attributes;
        }

        $this->render('index', ['model' => $model]);
    }


    public function loadModel($id)
    {
        $model = Coupon::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('CouponModule.coupon', 'Page not found!'));
        }

        return $model;
    }
}
