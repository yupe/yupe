<?php

class CallbackController extends \yupe\components\controllers\FrontController
{
    public function actionSend()
    {
        if (!Yii::app()->getRequest()->getIsPostRequest() && !Yii::app()->getRequest()->getPost('Callback')) {
            throw new CHttpException(404);
        }

        if(Yii::app()->callbackManager->add(Yii::app()->getRequest()->getPost('Callback')) === true) {
            Yii::app()->ajax->success(Yii::t('CallbackModule.callback', 'Your message has been successfully sent.'));
        } else {
            Yii::app()->ajax->failure(Yii::t('CallbackModule.callback', 'Sorry, an error has occurred.'));
        }
    }
}