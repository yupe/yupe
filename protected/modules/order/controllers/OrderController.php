<?php

class OrderController extends yupe\components\controllers\FrontController
{
    public function actionView($url = null)
    {
        $model = Order::model()->findByAttributes(['url' => $url]);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('OrderModule.order', 'Запрошенная страница не найдена.'));
        }
        $this->render('view', ['model' => $model]);
    }

    public function actionCreate()
    {
        $model = new Order(Order::SCENARIO_USER);

        if (Yii::app()->getRequest()->getIsPostRequest() && isset($_POST['Order'])) {
            $model->setAttributes(Yii::app()->getRequest()->getPost('Order'));
            $model->setOrderProducts(Yii::app()->getRequest()->getPost('OrderProduct'));
            if ($model->save()) {
                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('OrderModule.order', 'Заказ размещён!')
                );
                if (Yii::app()->hasModule('cart')) {
                    Yii::app()->getModule('cart')->clearCart();
                }
                $this->redirect(['/order/order/view', 'url' => $model->url]);
            } else {
                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    CHtml::errorSummary($model)
                );
            }
        }

        $this->redirect(Yii::app()->getUser()->getReturnUrl($_SERVER['HTTP_REFERER']));
    }
}
