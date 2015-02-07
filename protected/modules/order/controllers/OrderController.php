<?php

class OrderController extends \yupe\components\controllers\FrontController
{
    public function actionView($url = null)
    {
        if (!Yii::app()->getModule('order')->showOrder && !Yii::app()->getUser()->isAuthenticated()) {
            throw new CHttpException(404, Yii::t('OrderModule.order', 'Запрошенная страница не найдена.'));
        }

        $model = Order::model()->findByUrl($url);

        if ($model === null) {
            throw new CHttpException(404, Yii::t('OrderModule.order', 'Запрошенная страница не найдена.'));
        }

        $this->render('view', ['model' => $model]);
    }

    public function actionCreate()
    {
        $model = new Order(Order::SCENARIO_USER);

        if (Yii::app()->getRequest()->getIsPostRequest() && Yii::app()->getRequest()->getPost('Order')) {

            $model->setAttributes(Yii::app()->getRequest()->getPost('Order'));

            $model->setOrderProducts(Yii::app()->getRequest()->getPost('OrderProduct'));

            if ($model->validate()) {

                //@TODOпроверить возможность доставки
                $delivery = Delivery::model()->findById($model->delivery_id);

                if ($model->save()) {

                    Yii::app()->getUser()->setFlash(
                        yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t('OrderModule.order', 'Заказ размещён!')
                    );

                    if (Yii::app()->hasModule('cart')) {
                        Yii::app()->getModule('cart')->clearCart();
                    }

                    //отправить уведомления
                    Yii::app()->orderNotifyService->sendOrderCreatedAdminNotify($model);

                    Yii::app()->orderNotifyService->sendOrderCreatedUserNotify($model);


                    if (Yii::app()->getModule('order')->showOrder) {
                        $this->redirect(['/order/order/view', 'url' => $model->url]);
                    }

                    $this->redirect(['/store/catalog/index']);

                } else {
                    Yii::app()->getUser()->setFlash(
                        yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                        CHtml::errorSummary($model)
                    );
                }
            }else{
                 Yii::app()->getUser()->setFlash(
                        yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                        CHtml::errorSummary($model)
                    );
            }
        }

        $this->redirect(Yii::app()->getUser()->getReturnUrl($_SERVER['HTTP_REFERER']));
    }

    public function actionCheck()
    {
        if(!Yii::app()->getModule('order')->enableCheck) {
            throw new CHttpException(404);
        }

        $form = new CheckOrderForm();

        $order = null;

        if(Yii::app()->getRequest()->getIsPostRequest()) {

            $form->setAttributes(
                Yii::app()->getRequest()->getPost('CheckOrderForm')
            );

            if($form->validate()) {
                $order = Order::model()->findByNumber($form->number);
            }
        }

        $this->render('check', ['model' => $form, 'order' => $order]);
    }
}
