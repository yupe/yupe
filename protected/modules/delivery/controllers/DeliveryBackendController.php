<?php

class DeliveryBackendController extends yupe\components\controllers\BackController
{
    public function actions()
    {
        return [
            'inline' => [
                'class' => 'yupe\components\actions\YInLineEditAction',
                'model' => 'Delivery',
                'validAttributes' => [
                    'status'
                ]
            ],
            'sortable' => [
                'class' => 'yupe\components\actions\SortAction',
                'model' => 'Delivery'
            ]
        ];
    }

    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin'],],
            ['allow', 'actions' => ['index'], 'roles' => ['Delivery.DeliveryBackend.Index'],],
            ['allow', 'actions' => ['view'], 'roles' => ['Delivery.DeliveryBackend.View'],],
            ['allow', 'actions' => ['create'], 'roles' => ['Delivery.DeliveryBackend.Create'],],
            ['allow', 'actions' => ['update', 'sortable', 'inline'], 'roles' => ['Delivery.DeliveryBackend.Update'],],
            ['allow', 'actions' => ['delete', 'multiaction'], 'roles' => ['Delivery.DeliveryBackend.Delete'],],
            ['deny',],
        ];
    }

    public function actionView($id)
    {
        $this->render('view', ['model' => $this->loadModel($id)]);
    }


    public function actionCreate()
    {
        $model = new Delivery();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Delivery'])) {
            $model->attributes = $_POST['Delivery'];

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('DeliveryModule.delivery', 'Record created!')
                );

                if (!isset($_POST['submit-type'])) {
                    $this->redirect(['update', 'id' => $model->id]);
                } else {
                    $this->redirect([$_POST['submit-type']]);
                }
            }
        }
        $criteria = new CDbCriteria;
        $criteria->select = new CDbExpression('MAX(position) as position');
        $max = $model->find($criteria);

        $model->position = $max->position + 1;

        $payments = Payment::model()->published()->findAll(['order' => 'position']);

        $this->render('create', ['model' => $model, 'payments' => $payments]);
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Delivery'])) {
            $model->attributes = $_POST['Delivery'];

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('DeliveryModule.delivery', 'Record updated!')
                );

                if (!isset($_POST['submit-type'])) {
                    $this->redirect(['update', 'id' => $model->id]);
                } else {
                    $this->redirect([$_POST['submit-type']]);
                }
            }
        }

        $payments = Payment::model()->published()->findAll(['order' => 'position']);

        $this->render('update', ['model' => $model, 'payments' => $payments]);
    }

    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $this->loadModel($id)->delete();

            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('DeliveryModule.delivery', 'Record removed!')
            );

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['index']);
            }
        } else {
            throw new CHttpException(400, Yii::t(
                'DeliveryModule.delivery',
                'Unknown request. Don\'t repeat it please!'
            ));
        }
    }


    public function actionIndex()
    {
        $model = new Delivery('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Delivery'])) {
            $model->attributes = $_GET['Delivery'];
        }
        $this->render('index', ['model' => $model]);
    }


    public function loadModel($id)
    {
        $model = Delivery::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('DeliveryModule.delivery', 'Page not found!'));
        }

        return $model;
    }


    protected function performAjaxValidation(Delivery $model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'delivery-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
