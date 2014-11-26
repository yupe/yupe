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
            ]
        ];
    }

    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin'],],
            ['allow', 'actions' => ['create'], 'roles' => ['Payment.PaymentBackend.Create'],],
            ['allow', 'actions' => ['delete'], 'roles' => ['Payment.PaymentBackend.Delete'],],
            ['allow', 'actions' => ['update'], 'roles' => ['Payment.PaymentBackend.Update'],],
            ['allow', 'actions' => ['paymentSystemSettings'], 'roles' => ['Payment.PaymentBackend.Create', 'Payment.PaymentBackend.Update'],],
            ['allow', 'actions' => ['index'], 'roles' => ['Payment.PaymentBackend.Index'],],
            ['allow', 'actions' => ['sortable'], 'roles' => ['Payment.PaymentBackend.Update'],],
            ['allow', 'actions' => ['view'], 'roles' => ['Payment.PaymentBackend.View'],],
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
                    Yii::t('PaymentModule.payment', 'Запись добавлена!')
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
                    Yii::t('PaymentModule.payment', 'Запись обновлена!')
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
                Yii::t('PaymentModule.payment', 'Запись удалена!')
            );

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['index']);
            }
        } else {
            throw new CHttpException(400, Yii::t('PaymentModule.payment', 'Неверный запрос. Пожалуйста, больше не повторяйте такие запросы'));
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
            throw new CHttpException(404, Yii::t('PaymentModule.payment', 'Запрошенная страница не найдена.'));
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

    public function actionSortable()
    {
        $sortOrder = Yii::app()->request->getPost('sortOrder');

        if (empty($sortOrder)) {
            throw new CHttpException(404);
        }

        if (Payment::model()->sort($sortOrder)) {
            Yii::app()->ajax->success();
        }

        Yii::app()->ajax->failure();
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
