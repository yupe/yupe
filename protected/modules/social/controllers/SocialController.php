<?php
class SocialController extends YFrontController
{
    public function actionLogin()
    {
    	$service = Yii::app()->request->getQuery('service');

        if (isset($service))
        {
            $authIdentity = Yii::app()->eauth->getIdentity($service);

            $authIdentity->redirectUrl = Yii::app()->user->returnUrl;

            $authIdentity->cancelUrl = $this->createAbsoluteUrl('/social/social/login/');

            if ($authIdentity->authenticate())
            {
                $identity = new ServiceUserIdentity($authIdentity);

                // successful authentication
                if ($identity->authenticate())
                {
                    //проверить нет ли этого пользователя
                    $socialLogin = new SocialLoginIdentity(Yii::app()->user->getState('service'),Yii::app()->user->getState('id'));

                    if($socialLogin->authenticate())
                    {
                    	Yii::app()->user->login($identity);

                    	Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('user', 'Вы успешно авторизовались!'));

                        $this->redirect(array(Yii::app()->getModule('user')->loginSuccess));
                    }
                    else
                    {
                    	// пользователь новый, необходимо сделать редирект на форму окончания регистрации
                    	Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('user', 'Пожалуйста, завершите регистрацию!'));

                        $this->redirect(array('/social/social/registration/')); 
                    }                    

                    // special redirect with closing popup window
                    $authIdentity->redirect();
                }
                else
                {
                    // close popup window and redirect to cancelUrl
                    $authIdentity->cancel();
                }
            }

            // Something went wrong, redirect to login page
            $this->redirect(array('/social/social/login/'));
        }
    }
    
    public function actionRegistration()
    {
    	echo '!!!';
    }	
}