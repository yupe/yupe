<?php

/**
 * Class CallbackController
 */
class CallbackController extends \yupe\components\controllers\FrontController
{
    /**
     * @throws CHttpException
     */
    public function actionSend()
    {
        $request = Yii::app()->getRequest();

        if (!$request->getIsPostRequest() && !$request->getPost('Callback')) {
            throw new CHttpException(404);
        }

        if(Yii::app()->callbackManager->add($request->getPost('Callback'), $request->getUrlReferrer()) === true) {
            Yii::app()->ajax->success(Yii::t('CallbackModule.callback', 'Your message has been successfully sent.'));
        } else {
            Yii::app()->ajax->failure(Yii::t('CallbackModule.callback', 'Sorry, an error has occurred.'));
        }
    }
}