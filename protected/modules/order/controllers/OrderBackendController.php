<?php

class OrderBackendController extends yupe\components\controllers\BackController
{
    public function actions()
    {
        return array(
            'inline' => array(
                'class'           => 'yupe\components\actions\YInLineEditAction',
                'model'           => 'Order',
                'validAttributes' => array(
                    'status',
                    'paid'
                )
            )
        );
    }

    public function accessRules()
    {
        return array(
            array('allow', 'roles' => array('admin'),),
            array('allow', 'actions' => array('create'), 'roles' => array('Order.OrderBackend.Create'),),
            array('allow', 'actions' => array('delete'), 'roles' => array('Order.OrderBackend.Delete'),),
            array('allow', 'actions' => array('update'), 'roles' => array('Order.OrderBackend.Update'),),
            array('allow', 'actions' => array('index'), 'roles' => array('Order.OrderBackend.Index'),),
            array('allow', 'actions' => array('view'), 'roles' => array('Order.OrderBackend.View'),),
            array('allow', 'actions' => array('productRow'), 'roles' => array('Order.OrderBackend.Create', 'Order.OrderBackend.Update'),),
            array('deny',),
        );
    }

    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id)));
    }

    public function actionCreate()
    {
        $model = new Order();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Order'])) {
            $model->attributes = $_POST['Order'];
            $model->setOrderProducts($_POST['OrderProduct']);
            if ($model->save()) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('OrderModule.order', 'Запись добавлена!')
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

        if (isset($_POST['Order'])) {
            $model->attributes = $_POST['Order'];
            $model->setOrderProducts($_POST['OrderProduct']);

            if ($model->save()) {
                if (Yii::app()->request->getParam('notify_user', false)) {
                    //@TODO event
                }

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('OrderModule.order', 'Запись обновлена!')
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
                Yii::t('OrderModule.order', 'Запись удалена!')
            );

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        } else {
            throw new CHttpException(400, Yii::t('OrderModule.order', 'Неверный запрос. Пожалуйста, больше не повторяйте такие запросы'));
        }
    }

    public function actionIndex()
    {
        $model = new Order('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Order'])) {
            $model->attributes = $_GET['Order'];
        }
        $this->render('index', array('model' => $model));
    }

    /**
     * @param $id
     * @return Order
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Order::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('OrderModule.order', 'Запрошенная страница не найдена.'));
        }
        return $model;
    }

    protected function performAjaxValidation(Order $model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'order-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionProductRow()
    {
        $product = new OrderProduct();
        $product->product = Product::model()->findByPk($_GET['OrderProduct']['product_id']);

        $this->renderPartial('_product_row', array('model' => $product));
    }
}
