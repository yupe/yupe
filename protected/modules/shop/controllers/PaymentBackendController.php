<?php

class PaymentBackendController extends yupe\components\controllers\BackController
{
    public function accessRules()
    {
        return array(
            array('allow', 'roles' => array('admin'),),
            array('allow', 'actions' => array('create'), 'roles' => array('Shop.PaymentBackend.Create'),),
            array('allow', 'actions' => array('delete'), 'roles' => array('Shop.PaymentBackend.Delete'),),
            array('allow', 'actions' => array('update'), 'roles' => array('Shop.PaymentBackend.Update'),),
            array('allow', 'actions' => array('paymentSystemSettings'), 'roles' => array('Shop.PaymentBackend.Create', 'Shop.PaymentBackend.Update'),),
            array('allow', 'actions' => array('index'), 'roles' => array('Shop.PaymentBackend.Index'),),
            array('allow', 'actions' => array('sortable'), 'roles' => array('Shop.PaymentBackend.Update'),),
            array('allow', 'actions' => array('view'), 'roles' => array('Shop.PaymentBackend.View'),),
            array('deny',),
        );
    }

    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id)));
    }


    public function actionCreate()
    {
        $model = new Payment();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Payment']))
        {
            $model->attributes = $_POST['Payment'];
            $model->setPaymentSystemSettings($_POST['PaymentSettings']);
            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('ShopModule.payment', 'Запись добавлена!')
                );

                if (!isset($_POST['submit-type']))
                {
                    $this->redirect(array('update', 'id' => $model->id));
                }
                else
                {
                    $this->redirect(array($_POST['submit-type']));
                }
            }
        }
        $criteria         = new CDbCriteria;
        $criteria->select = new CDbExpression('MAX(position) as position');
        $max              = $model->find($criteria);

        $model->position = $max->position + 1;
        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Payment']))
        {
            $model->attributes = $_POST['Payment'];
            $model->setPaymentSystemSettings($_POST['PaymentSettings']);

            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('ShopModule.payment', 'Запись обновлена!')
                );

                if (!isset($_POST['submit-type']))
                {
                    $this->redirect(array('update', 'id' => $model->id));
                }
                else
                {
                    $this->redirect(array($_POST['submit-type']));
                }
            }
        }
        $this->render('update', array('model' => $model));
    }

    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest())
        {
            $this->loadModel($id)->delete();

            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('ShopModule.payment', 'Запись удалена!')
            );

            if (!isset($_GET['ajax']))
            {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        }
        else
        {
            throw new CHttpException(400, Yii::t('ShopModule.payment', 'Неверный запрос. Пожалуйста, больше не повторяйте такие запросы'));
        }
    }


    public function actionIndex()
    {
        $model = new Payment('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Payment']))
            $model->attributes = $_GET['Payment'];
        $this->render('index', array('model' => $model));
    }


    /**
     * @param $id
     * @return Payment
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Payment::model()->findByPk($id);
        if ($model === null)
        {
            throw new CHttpException(404, Yii::t('ShopModule.payment', 'Запрошенная страница не найдена.'));
        }
        return $model;
    }


    protected function performAjaxValidation(Payment $model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'payment-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionSortable()
    {
        $sortOrder = Yii::app()->request->getPost('sortOrder');

        if (empty($sortOrder))
        {
            throw new CHttpException(404);
        }

        if (Payment::model()->sort($sortOrder))
        {
            Yii::app()->ajax->success();
        }

        Yii::app()->ajax->failure();
    }

    public function actionPaymentSystemSettings()
    {
        $payment = Payment::model()->findByPk(Yii::app()->request->getParam('payment_id'));
        $this->renderPartial('_payment_system_settings', array('model' => $payment, 'paymentSystem' => Yii::app()->request->getParam('payment_system')));
    }
}
