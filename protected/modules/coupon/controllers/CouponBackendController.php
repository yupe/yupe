<?php

class CouponBackendController extends yupe\components\controllers\BackController
{
    public function actions()
    {
        return [
            'inline' => [
                'class'           => 'yupe\components\actions\YInLineEditAction',
                'model'           => 'Coupon',
                'validAttributes' => [
                    'status'
                ]
            ]
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

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Coupon'])) {
            $model->attributes = $_POST['Coupon'];

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('CouponModule.coupon', 'Record created!')
                );

                if (!isset($_POST['submit-type'])) {
                    $this->redirect(['update', 'id' => $model->id]);
                } else {
                    $this->redirect([$_POST['submit-type']]);
                }
            }
        }
        $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Coupon'])) {
            $model->attributes = $_POST['Coupon'];

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('CouponModule.coupon', 'Record updated!')
                );

                if (!isset($_POST['submit-type'])) {
                    $this->redirect(['update', 'id' => $model->id]);
                } else {
                    $this->redirect([$_POST['submit-type']]);
                }
            }
        }
        $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $this->loadModel($id)->delete();

            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('CouponModule.coupon', 'Record removed!')
            );

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['index']);
            }
        } else {
            throw new CHttpException(400, Yii::t('CouponModule.coupon', 'Unknown request. Don\'t repeat it please!'));
        }
    }


    public function actionIndex()
    {
        $model = new Coupon('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Coupon'])) {
            $model->attributes = $_GET['Coupon'];
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


    protected function performAjaxValidation(Coupon $model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'coupon-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
