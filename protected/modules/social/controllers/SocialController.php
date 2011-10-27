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
                        // попробуем создать учетную запись, если такой ник уже есть - редирект на форму регистрации
                        $nick_name = preg_replace('/[^A-Za-z0-9]/','', YText::translit(Yii::app()->user->getState('name')));                       

                        $user = User::model()->find('LOWER(nick_name) = :nick_name',array(
                            ':nick_name' => strtolower($nick_name)
                        ));

                        if($user)
                        {                           
                            Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('user', 'Пожалуйста, завершите регистрацию!'));

                            $this->redirect(array('/social/social/registration/'));     
                        }

                        $registration = Registration::model()->find('LOWER(nick_name) = :nick_name',array(
                            ':nick_name' => strtolower($nick_name)
                        ));

                        if($registration)
                        {                           
                            Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('user', 'Пожалуйста, завершите регистрацию!'));

                            $this->redirect(array('/social/social/registration/'));     
                        }
                        
                        $account = new User;
                        
                        $account->createAccount($nick_name,"{$nick_name}@{$nick_name}.ru");

                        if($account && !$account->hasErrors())
                        {
                            var_dump(Yii::app()->user->getState('id').' '.Yii::app()->user->getState('service'));die();
                            //создадим запись в Login
                            $login = new Login;

                            $login->setAttributes(array(
                                'user_id'     => $account->id,
                                'identity_id' => Yii::app()->user->getState('id'),
                                'type'        => Yii::app()->user->getState('service'), 
                            ));

                            if(!$login->save())
                                var_dump($login->getErrors());die();
                        }

                        var_dump($account->getErrors());die('!!!nooo!!');
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
    	$id = Yii::app()->user->getState('id');

        $name = Yii::app()->user->getState('name');

        $service = Yii::app()->user->getState('service');        

        if(!isset($id,$name,$service))
        {
            Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE,Yii::t('user','При авторизации произошла ошибка!'));

            $this->redirect(array('/user/account/login/'));
        }

        $model = new User;

        $this->render('registration',array('model' => $model));        
    }	
}