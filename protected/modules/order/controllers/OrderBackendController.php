<?php

/**
 * Class OrderBackendController
 */
class OrderBackendController extends yupe\components\controllers\BackController
{

    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     *
     */
    public function init()
    {
        $this->productRepository = Yii::app()->getComponent('productRepository');

        parent::init();
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'inline' => [
                'class' => 'yupe\components\actions\YInLineEditAction',
                'model' => 'Order',
                'validAttributes' => [
                    'status_id',
                    'paid',
                ],
            ],
        ];
    }

    /**
     * @return array
     */
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

    /**
     * @param $id
     * @throws CHttpException
     */
    public function actionView($id)
    {
        $model = $this->loadModel($id);

        $this->render('view', ['model' => $model, 'products' => $model->getProducts()]);
    }

    /**
     *
     */
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
                }

                $this->redirect([$_POST['submit-type']]);
            }
        }

        $this->render('create', ['model' => $model]);
    }

    /**
     * @param $id
     * @throws CHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (Yii::app()->getRequest()->getIsPostrequest() && Yii::app()->getRequest()->getPost('Order')) {

            $order = Yii::app()->getRequest()->getPost('Order', []);

            $products = Yii::app()->getRequest()->getPost('OrderProduct', []);

            $coupons = isset($order['couponCodes']) ? $order['couponCodes'] : [];

            if ($model->store($order, $products)) {

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

    /**
     * @param $id
     * @throws CDbException
     * @throws CHttpException
     */
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
            throw new CHttpException(
                400, Yii::t(
                'OrderModule.order',
                'Unknown request. Don\'t repeat it please!'
            )
            );
        }
    }

    /**
     *
     */
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

        if (null === $model) {
            throw new CHttpException(404, Yii::t('OrderModule.order', 'Page not found!'));
        }

        return $model;
    }

    /**
     * @param Order $model
     */
    protected function performAjaxValidation(Order $model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'order-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * @throws CException
     */
    public function actionProductRow()
    {
        $product = new OrderProduct();
        $product->product = Product::model()->findByPk($_GET['OrderProduct']['product_id']);
        $this->renderPartial('_product_row', ['model' => $product]);
    }


    /**
     * @throws CHttpException
     */
    public function actionAjaxClientSearch()
    {
        if (!Yii::app()->getRequest()->getQuery('q')) {
            throw new CHttpException(404);
        }

        $query = Yii::app()->getRequest()->getQuery('q');

        $model = new Client('search');
        $model->first_name = $query;
        $model->last_name = $query;
        $model->middle_name = $query;
        $model->nick_name = $query;

        $data = [];

        foreach ($model->search()->getData() as $client) {
            $data[] = [
                'id' => $client->id,
                'name' => sprintf('%s (%s %s)', $client->getFullName(), $client->phone, $client->email),
            ];
        }

        Yii::app()->ajax->raw($data);
    }


    /**
     * @throws CHttpException
     */

    public function actionAjaxProductSearch()
    {
        if (!Yii::app()->getRequest()->getQuery('q')) {
            throw new CHttpException(404);
        }

        $data = [];

        $model = $this->productRepository->searchByName(Yii::app()->getRequest()->getQuery('q'));

        foreach ($model as $product) {
            $data[] = [
                'id' => $product->id,
                'name' => $product->name . ($product->sku ? " ({$product->sku}) " : ' ') . $product->getPrice() . ' ' . Yii::t('StoreModule.store', Yii::app()->getModule('store')->currency),
                'thumb' => $product->image ? $product->getImageUrl(50, 50) : '',
            ];
        }

        Yii::app()->ajax->raw($data);
    }
}
