<?php

class UserController extends yupe\components\controllers\FrontController
{
    public function actionLogin()
    {
        $serviceName = Yii::app()->request->getQuery('service');

        if ($serviceName !== null) {
            $eauth = Yii::app()->eauth->getIdentity($serviceName);
            $eauth->redirectUrl = Yii::app()->user->returnUrl;
            $eauth->cancelUrl = $this->createAbsoluteUrl('/login');
            try {
                if ($eauth->authenticate()) {
                    $identity = new EAuthUserIdentity($eauth);
                    if ($identity->authenticate()) {
                        Yii::app()->user->login($identity);
                        $session = Yii::app()->session;
                        $session['eauth_profile'] = $eauth->attributes;
                        $eauth->redirect();
                    } else {
                        $eauth->cancel();
                    }
                }
                $this->redirect(array('/login'));
            } catch (EAuthException $e) {
                Yii::app()->user->setFlash('error', 'EAuthException: ' . $e->getMessage());
                $eauth->redirect($eauth->getCancelUrl());
            }
        }
    }
}