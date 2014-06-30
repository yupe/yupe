<?php

class OrderController extends yupe\components\controllers\FrontController
{

    public function actionView($url = null)
    {
        $model = Order::model()->findByAttributes(array('url' => $url));
        if ($model === null)
        {
            throw new CHttpException(404, Yii::t('ShopModule.order', 'Запрошенная страница не найдена.'));
        }
        $this->render('view', array('model' => $model));
    }


    public function actionCreate()
    {
        $model = new Order(Order::SCENARIO_USER);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Order']))
        {
            $model->attributes = $_POST['Order'];
            $model->setOrderProducts($_POST['OrderProduct']);
            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('ShopModule.order', 'Заказ размещён!')
                );
                Yii::app()->shoppingCart->clear();
                // отправка оповещений
                $this->module->sendNotifyOrderCreated($model);
                $this->redirect(array('/shop/order/view', 'url' => $model->url));
            }
            else
            {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    CHtml::errorSummary($model)
                );
            }
        }

        $this->redirect(array('/shop/cart/index'));
    }
}
