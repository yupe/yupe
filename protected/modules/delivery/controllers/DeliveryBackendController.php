<?php

class DeliveryBackendController extends yupe\components\controllers\BackController
{
    public function actions()
    {
        return array(
            'inline' => array(
                'class'           => 'yupe\components\actions\YInLineEditAction',
                'model'           => 'Delivery',
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
            array('allow', 'actions' => array('create'), 'roles' => array('Delivery.DeliveryBackend.Create'),),
            array('allow', 'actions' => array('delete'), 'roles' => array('Delivery.DeliveryBackend.Delete'),),
            array('allow', 'actions' => array('update'), 'roles' => array('Delivery.DeliveryBackend.Update'),),
            array('allow', 'actions' => array('index'), 'roles' => array('Delivery.DeliveryBackend.Index'),),
            array('allow', 'actions' => array('sortable'), 'roles' => array('Delivery.DeliveryBackend.Update'),),
            array('allow', 'actions' => array('view'), 'roles' => array('Delivery.DeliveryBackend.View'),),
            array('deny',),
        );
    }

    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id)));
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
                    Yii::t('DeliveryModule.delivery', 'Запись добавлена!')
                );

                if (!isset($_POST['submit-type'])) {
                    $this->redirect(array('update', 'id' => $model->id));
                } else {
                    $this->redirect(array($_POST['submit-type']));
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
                    Yii::t('DeliveryModule.delivery', 'Запись обновлена!')
                );

                if (!isset($_POST['submit-type'])) {
                    $this->redirect(array('update', 'id' => $model->id));
                } else {
                    $this->redirect(array($_POST['submit-type']));
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
                Yii::t('DeliveryModule.delivery', 'Запись удалена!')
            );

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        } else {
            throw new CHttpException(400, Yii::t('DeliveryModule.delivery', 'Неверный запрос. Пожалуйста, больше не повторяйте такие запросы'));
        }
    }


    public function actionIndex()
    {
        $model = new Delivery('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Delivery'])) {
            $model->attributes = $_GET['Delivery'];
        }
        $this->render('index', array('model' => $model));
    }


    public function loadModel($id)
    {
        $model = Delivery::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('DeliveryModule.delivery', 'Запрошенная страница не найдена.'));
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

    public function actionSortable()
    {
        $sortOrder = Yii::app()->request->getPost('sortOrder');

        if (empty($sortOrder)) {
            throw new CHttpException(404);
        }

        if (Delivery::model()->sort($sortOrder)) {
            Yii::app()->ajax->success();
        }

        Yii::app()->ajax->failure();
    }
}
