<?php

class PaymentBackendController extends yupe\components\controllers\BackController
{
    public function actions()
    {
        return [
            'inline' => [
                'class'           => 'yupe\components\actions\YInLineEditAction',
                'model'           => 'Payment',
                'validAttributes' => [
                    'status'
                ]
            ],
            'sortable' => [
                'class' => 'yupe\components\actions\SortAction',
                'model' => 'Payment'
            ]
        ];
    }

    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin'],],
            ['allow', 'actions' => ['index'], 'roles' => ['Payment.PaymentBackend.Index'],],
            ['allow', 'actions' => ['view'], 'roles' => ['Payment.PaymentBackend.View'],],
            ['allow', 'actions' => ['create', 'paymentSystemSettings'], 'roles' => ['Payment.PaymentBackend.Create'],],
            ['allow', 'actions' => ['update', 'sortable', 'inline', 'paymentSystemSettings'], 'roles' => ['Payment.PaymentBackend.Update'],],
            ['allow', 'actions' => ['delete', 'multiaction'], 'roles' => ['Payment.PaymentBackend.Delete'],],
            ['deny',],
        ];
    }

    public function actionView($id)
    {
        $this->render('view', ['model' => $this->loadModel($id)]);
    }

    public function actionCreate()
    {
        $model = new Payment();

        if (Yii::app()->getRequest()->getIsPostRequest() && isset($_POST['Payment'])) {
            $model->setAttributes(Yii::app()->getRequest()->getPost('Payment'));
            $model->setPaymentSystemSettings(Yii::app()->getRequest()->getPost('PaymentSettings', []));
            if ($model->save()) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('PaymentModule.payment', 'Record was created!')
                );

                if (!isset($_POST['submit-type'])) {
                    $this->redirect(['update', 'id' => $model->id]);
                } else {
                    $this->redirect([$_POST['submit-type']]);
                }
            }
        }

        //@TODO вынести в метод модели
        $criteria = new CDbCriteria;
        $criteria->select = new CDbExpression('MAX(position) as position');
        $max = $model->find($criteria);

        $model->position = $max->position + 1;
        $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (Yii::app()->getRequest()->getIsPostRequest() && isset($_POST['Payment'])) {
            $model->setAttributes(Yii::app()->getRequest()->getPost('Payment'));
            $model->setPaymentSystemSettings(Yii::app()->getRequest()->getPost('PaymentSettings', []));
            if ($model->save()) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('PaymentModule.payment', 'Record was updated!')
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
                Yii::t('PaymentModule.payment', 'Record was removed!')
            );

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['index']);
            }
        } else {
            throw new CHttpException(400, Yii::t('PaymentModule.payment', 'Unknown request. Don\'t repeat it please!'));
        }
    }


    public function actionIndex()
    {
        $model = new Payment('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Payment'])) {
            $model->attributes = $_GET['Payment'];
        }
        $this->render('index', ['model' => $model]);
    }


    /**
     * @param $id
     * @return Payment
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Payment::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('PaymentModule.payment', 'Page not found!'));
        }
        return $model;
    }


    protected function performAjaxValidation(Payment $model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'payment-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionPaymentSystemSettings()
    {
        $payment = Payment::model()->findByPk(Yii::app()->request->getParam('payment_id'));
        $this->renderPartial(
            '_payment_system_settings',
            [
                'paymentSystem' => Yii::app()->request->getParam('payment_system'),
                'paymentSettings' => $payment ? $payment->getPaymentSystemSettings() : [],
            ]
        );
    }
}
