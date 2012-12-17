<?php
class SocialController extends YFrontController
{
    private function cleanState()
    {
        Yii::app()->user->setState('sid', null);
        Yii::app()->user->setState('name', null);
        Yii::app()->user->setState('service', null);
    }

    public function actionLogin()
    {
        $service = Yii::app()->request->getQuery('service');

        if ($service !== null)
        {
            $authIdentity = Yii::app()->eauth->getIdentity($service);
            $authIdentity->redirectUrl = Yii::app()->user->returnUrl;
            $authIdentity->cancelUrl = $this->createAbsoluteUrl('/social/social/login');

            // если авторизовались через сервис
            if ($authIdentity->authenticate())
            {
                $identity = new ServiceUserIdentity($authIdentity);
                // successful authentication
                if ($identity->authenticate())
                {
                    //проверить нет ли уже этого пользователя
                    $socialLogin = new SocialLoginIdentity(Yii::app()->user->getState('service'), Yii::app()->user->getState('sid'));
                    if ($socialLogin->authenticate())
                    {
                        $this->cleanState();

                        Yii::app()->user->login($socialLogin);
                        Yii::app()->user->setFlash(
                            YFlashMessages::NOTICE_MESSAGE,
                            Yii::t('social', 'Вы успешно авторизовались!')
                        );

                        //редирект с закрытием окна
                        $authIdentity->redirect(array(Yii::app()->getModule('user')->loginSuccess));
                    }
                    else
                    {
                        // попробуем создать учетную запись, если такой ник уже есть - редирект на форму регистрации
                        $nick_name = preg_replace('/[^A-Za-z0-9]/','', YText::translit($authIdentity->getAttribute('nick')));

                        $user = User::model()->find('LOWER(nick_name) = :nick_name', array(
                            ':nick_name' => strtolower($nick_name)
                        ));

                        if ($user)
                        {
                            Yii::app()->user->setFlash(
                                YFlashMessages::NOTICE_MESSAGE,
                                Yii::t('social', 'Пожалуйста, завершите регистрацию, имя пользователя "{nick_name}" к сожалению, уже занято...', array('{nick_name}' => $nick_name))
                            );
                            $this->redirect(array('/social/social/registration'));
                        }

                        //если пользователь уже авторизован - привязка к текущему аккаунту
                        if (Yii::app()->user->isAuthenticated())
                        {
                            //создадим запись в Login
                            $login = new Login;

                            $login->setAttributes(array(
                                'user_id'     => Yii::app()->user->getId(),
                                'identity_id' => Yii::app()->user->getState('sid'),
                                'type'        => Yii::app()->user->getState('service'),
                            ));

                            //@TODO как-то иначе обработать неудачу
                            if (!$login->save())
                                throw new CDbException(Yii::t('social', 'При создании учетной записи произошла ошибка!'));

                            Yii::app()->user->setFlash(
                                YFlashMessages::NOTICE_MESSAGE,
                                Yii::t('social', 'Аккаунт привязан!')
                            );

                            $authIdentity->redirect(array(Yii::app()->getModule('user')->loginSuccess));
                        } 

                        $transaction = Yii::app()->db->beginTransaction();

                        try
                        {
                            $email = $authIdentity->getAttribute('email');

                            $account = new User;

                            $account->createAccount(
                                $nick_name,
                                $email,
                                null, 
                                null, 
                                User::STATUS_ACTIVE,
                                (empty($email) ? User::EMAIL_CONFIRM_NO : User::EMAIL_CONFIRM_YES),
                                $authIdentity->getAttribute('first_name'),
                                $authIdentity->getAttribute('last_name')
                            );

                            if ($account && !$account->hasErrors())
                            {
                                //создадим запись в Login
                                $login = new Login;

                                $login->setAttributes(array(
                                    'user_id'     => $account->id,
                                    'identity_id' => Yii::app()->user->getState('sid'),
                                    'type'        => Yii::app()->user->getState('service'),
                                ));

                                if (!$login->save())
                                    throw new CDbException(Yii::t('social', 'При создании учетной записи произошла ошибка!'));
                            }

                            $transaction->commit();

                            // авторизуем нового пользователя
                            $socialLogin = new SocialLoginIdentity(Yii::app()->user->getState('service'), Yii::app()->user->getState('sid'));

                            if ($socialLogin->authenticate())
                            {
                                $this->cleanState();

                                Yii::app()->user->login($socialLogin);
                                Yii::app()->user->setFlash(
                                    YFlashMessages::NOTICE_MESSAGE,
                                    Yii::t('social', 'Вы успешно авторизовались!')
                                );

                                $this->redirect(array(Yii::app()->getModule('user')->loginSuccess));
                            }
                            else
                            {
                                Yii::app()->user->setFlash(
                                    YFlashMessages::ERROR_MESSAGE,
                                    Yii::t('social', 'Учетная запись создана, но не удалось авторизоваться!')
                                );

                                $this->cleanState();

                                $this->redirect(array('/user/account/login'));
                            }
                        }
                        catch(Exception $e)
                        {
                            $transaction->rollback();

                            Yii::log(
                                Yii::t('social', "При авторизации через {servive} произошла ошибка!", array(
                                    '{servive}' => Yii::app()->user->getState('service')
                                )),
                                CLogger::LEVEL_ERROR
                            );

                            Yii::app()->user->setFlash(
                                YFlashMessages::ERROR_MESSAGE,
                                Yii::t('social', 'При создании учетной записи произошла ошибка {error}!', array('{error}' => $e->getMessage()))
                            );

                            $this->cleanState();

                            $this->redirect(array('/social/social/registration'));
                        }
                    }
                   // special redirect with closing popup window
                    $authIdentity->redirect();
                }
                else
                    $authIdentity->cancel(); // close popup window and redirect to cancelUrl
            }
            // Something went wrong, redirect to login page
            $this->redirect(array('/social/social/login'));
        }
    }

    public function actionRegistration()
    {
        $id      = Yii::app()->user->getState('sid');
        $name    = Yii::app()->user->getState('name');
        $service = Yii::app()->user->getState('service');

        if (!isset($id, $name, $service))
        {
            Yii::app()->user->setFlash(
                YFlashMessages::ERROR_MESSAGE,
                Yii::t('social', 'При авторизации произошла ошибка!')
            );
            $this->redirect(array('/user/account/login'));
        }

        $model = new User;

        if (Yii::app()->request->isPostRequest && !empty($_POST['User']))
        {
            $nick_name   = $_POST['User']['nick_name'];
            $transaction = Yii::app()->db->beginTransaction();

            try
            {
                $model->createAccount($nick_name, "{$nick_name}@{$nick_name}.ru", null, null, User::STATUS_ACTIVE);

                if ($model && !$model->hasErrors())
                {
                    //создадим запись в Login
                    $login = new Login;

                    $login->setAttributes(array(
                        'user_id'     => $model->id,
                        'identity_id' => Yii::app()->user->getState('sid'),
                        'type'        => Yii::app()->user->getState('service'),
                    ));

                    if(!$login->save())
                        throw new CDbException(Yii::t('social', 'При создании учетной записи произошла ошибка!'));

                    $transaction->commit();
                }
                else
                    throw new CDbException(Yii::t('social', 'При создании учетной записи произошла ошибка!'));

                // авторизуем нового пользователя
                $socialLogin = new SocialLoginIdentity(Yii::app()->user->getState('service'), Yii::app()->user->getState('sid'));

                if ($socialLogin->authenticate())
                {
                    $this->cleanState();

                    Yii::app()->user->login($socialLogin);
                    Yii::app()->user->setFlash(
                        YFlashMessages::NOTICE_MESSAGE,
                        Yii::t('social', 'Вы успешно авторизовались!')
                    );

                    $this->redirect(array(Yii::app()->getModule('user')->loginSuccess));
                }
                else
                {
                    Yii::app()->user->setFlash(
                        YFlashMessages::ERROR_MESSAGE,
                        Yii::t('social', 'При авторизации произошла ошибка!')
                    );

                    $this->cleanState();

                    $this->redirect(array('/user/account/login'));
                }
            }
            catch(Exception $e)
            {
                $transaction->rollback();

                $this->cleanState();

                Yii::log(
                    Yii::t('social', "При авторизации через {servive} произошла ошибка!", array(
                        '{servive}' => Yii::app()->user->getState('service')
                    )),
                    CLogger::LEVEL_ERROR
                );

                Yii::app()->user->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    Yii::t('social', 'При создании учетной записи произошла ошибка!')
                );

                $this->redirect(array('/user/account/login'));
            }
        }
        $this->render('registration', array('model' => $model));
    }
}