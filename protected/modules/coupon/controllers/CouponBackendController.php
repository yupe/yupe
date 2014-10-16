<?php

class CouponBackendController extends yupe\components\controllers\BackController
{
    public function actions()
    {
        return array(
            'inline' => array(
                'class'           => 'yupe\components\actions\YInLineEditAction',
                'model'           => 'Coupon',
                'validAttributes' => array(
                    'status'
                )
            )
        );
    }

    public function accessRules()
    {
        return array(
            array('allow', 'roles' => array('admin'),),
            array('allow', 'actions' => array('create'), 'roles' => array('Coupon.CouponBackend.Create'),),
            array('allow', 'actions' => array('delete'), 'roles' => array('Coupon.CouponBackend.Delete'),),
            array('allow', 'actions' => array('update'), 'roles' => array('Coupon.CouponBackend.Update'),),
            array('allow', 'actions' => array('index'), 'roles' => array('Coupon.CouponBackend.Index'),),
            array('allow', 'actions' => array('view'), 'roles' => array('Coupon.CouponBackend.View'),),
            array('deny',),
        );
    }

    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id)));
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
                    Yii::t('CouponModule.coupon', 'Запись добавлена!')
                );

                if (!isset($_POST['submit-type'])) {
                    $this->redirect(array('update', 'id' => $model->id));
                } else {
                    $this->redirect(array($_POST['submit-type']));
                }
            }
        }
        $this->render('create', array('model' => $model));
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
                    Yii::t('CouponModule.coupon', 'Запись обновлена!')
                );

                if (!isset($_POST['submit-type'])) {
                    $this->redirect(array('update', 'id' => $model->id));
                } else {
                    $this->redirect(array($_POST['submit-type']));
                }
            }
        }
        $this->render('update', array('model' => $model));
    }

    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $this->loadModel($id)->delete();

            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('CouponModule.coupon', 'Запись удалена!')
            );

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        } else {
            throw new CHttpException(400, Yii::t('CouponModule.coupon', 'Неверный запрос. Пожалуйста, больше не повторяйте такие запросы'));
        }
    }


    public function actionIndex()
    {
        $model = new Coupon('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Coupon'])) {
            $model->attributes = $_GET['Coupon'];
        }
        $this->render('index', array('model' => $model));
    }


    public function loadModel($id)
    {
        $model = Coupon::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('CouponModule.coupon', 'Запрошенная страница не найдена.'));
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
