<?php
use yupe\components\controllers\FrontController;
use yupe\widgets\YFlashMessages;

/**
 * Class PaymentController
 */
class PaymentController extends FrontController
{
    /**
     * @throws CException
     * @throws CHttpException
     */
    public function actionInit()
    {
        $orderId = Yii::app()->getRequest()->getParam('order');
        $order = Order::model()->findByPk($orderId);
        if (!$order) {
            Yii::app()->getUser()->setFlash(YFlashMessages::ERROR_MESSAGE,
                Yii::t('PaymentModule.payment', 'Unknown request. Don\'t repeat it please!')
            );
            $this->redirect('/');
        }

        $moduleId = $this->module->getId();

        /** @var YM3PaymentSystem $paymentSystem */
        $paymentSystem = Yii::app()->paymentManager->getPaymentSystemObject($moduleId);

        try {
            $paymentSystem->processInit(Yii::app()->getRequest(), $order);
        } catch (Exception $e) {
            $m = $e->getMessage();
            Yii::app()->getUser()->setFlash(YFlashMessages::ERROR_MESSAGE, $m);
            Yii::log($m, CLogger::LEVEL_ERROR);
            $this->redirect(['/order/order/view', 'url' => $order->url]);
        }
    }
}
