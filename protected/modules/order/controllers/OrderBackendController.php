<?php

class OrderBackendController extends yupe\components\controllers\BackController
{
    public function actions()
    {
        return [
            'inline' => [
                'class' => 'yupe\components\actions\YInLineEditAction',
                'model' => 'Order',
                'validAttributes' => [
                    'status_id',
                    'paid'
                ]
            ]
        ];
    }

    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin'],],
            ['allow', 'actions' => ['index'], 'roles' => ['Order.OrderBackend.Index'],],
            ['allow', 'actions' => ['view'], 'roles' => ['Order.OrderBackend.View'],],
            ['allow', 'actions' => ['create', 'productRow'], 'roles' => ['Order.OrderBackend.Create'],],
            ['allow', 'actions' => ['update', 'inline', 'productRow'], 'roles' => ['Order.OrderBackend.Update'],],
            ['allow', 'actions' => ['delete', 'multiaction'], 'roles' => ['Order.OrderBackend.Delete'],],
            ['deny',],
        ];
    }

    public function actionView($id)
    {
        $this->render('view', ['model' => $this->loadModel($id)]);
    }

    public function actionCreate()
    {
        $model = new Order();

        if (Yii::app()->getRequest()->getIsPostrequest() && Yii::app()->getRequest()->getPost('Order')) {

            $model->setAttributes(Yii::app()->getRequest()->getPost('Order'));

            $model->setProducts(Yii::app()->getRequest()->getPost('OrderProduct', 'null'));

            if ($model->save()) {
                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('OrderModule.order', 'Record created!')
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

        if (Yii::app()->getRequest()->getIsPostrequest() && Yii::app()->getRequest()->getPost('Order')) {

            $order = Yii::app()->getRequest()->getPost('Order', []);

            $products = Yii::app()->getRequest()->getPost('OrderProduct', []);

            $coupons = isset($order['couponCodes']) ? $order['couponCodes'] : [];

            if ($model->saveData($order, $products)) {

                if (!empty($coupons)) {
                    $model->applyCoupons($coupons);
                }

                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('OrderModule.order', 'Record updated!')
                );

                // отправить уведомление о смене статуса заказа
                if (Yii::app()->getRequest()->getParam('notify_user', false)) {

                    Yii::app()->orderNotifyService->sendOrderChangesNotify($model);

                    Yii::app()->getUser()->setFlash(
                        yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t('OrderModule.order', 'Record updated! Notification is sent!')
                    );
                }

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

            Yii::app()->getUser()->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('OrderModule.order', 'Record removed!')
            );

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['index']);
            }
        } else {
            throw new CHttpException(400, Yii::t(
                'OrderModule.order',
                'Unknown request. Don\'t repeat it please!'
            ));
        }
    }

    public function actionIndex()
    {
        $model = new Order('search');
        $model->unsetAttributes(); // clear any default values
        if (Yii::app()->getRequest()->getQuery('Order')) {
            $model->setAttributes(Yii::app()->getRequest()->getQuery('Order'));
        }
        $this->render('index', ['model' => $model]);
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
            throw new CHttpException(404, Yii::t('OrderModule.order', 'Page not found!'));
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
        $this->renderPartial('_product_row', ['model' => $product]);
    }
}
