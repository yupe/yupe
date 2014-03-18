<?php
namespace application\modules\social\controllers;

use yupe\components\controllers\FrontController;
use yupe\widgets\YFlashMessages;
use application\modules\social\components\UserIdentity;

use Yii;
use EAuthException;
use CHttpException;
use CModelEvent;
use User;
use RegistrationForm;
use CLogger;
use UserModule;
use SocialUser;
use LoginForm;
use Exception;
use CException;

class UserController extends FrontController
{
    protected $service;

    protected function beforeAction($action)
    {
        $id = Yii::app()->getRequest()->getQuery('service');
        $this->service = Yii::app()->getComponent('eauth')->getIdentity($id);

        return parent::beforeAction($action);
    }

    /**
     * @var $service \IAuthService
     */
    public function actionLogin()
    {
        try {
            if ($this->service->authenticate()) {

                $identity = new UserIdentity($this->service);

                if ($identity->authenticate() && Yii::app()->getUser()->login($identity)) {

                    Yii::app()->user->setFlash(
                        YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t('SocialModule.social', 'Вы успешно вошли!')
                    );

                    $module = Yii::app()->getModule('user');

                    $redirect = (Yii::app()->user->isSuperUser() && $module->loginAdminSuccess)
                        ? array($module->loginAdminSuccess)
                        : array($module->loginSuccess);

                    Yii::app()->authenticationManager->setBadLoginCount(Yii::app()->user, 0);

                    $this->redirect(Yii::app()->user->getReturnUrl($redirect));
                }

                if ($this->service->hasAttribute('email') && Yii::app()->userManager->isUserExist(
                        $this->service->email
                    )
                ) {
                    Yii::app()->user->setFlash(
                        YFlashMessages::INFO_MESSAGE,
                        Yii::t(
                            'SocialModule.social',
                            'Аккаунт с таким адресом уже существует! Войдите если хотите присоединить эту социальную сеть к своему аккаунту.'
                        )
                    );
                    $this->redirect(array('/social/connect', 'service' => $this->service->getServiceName()));
                }
                $this->redirect(array('/social/register', 'service' => $this->service->getServiceName()));
            }
            $this->redirect('/login');
        } catch (EAuthException $e) {
            Yii::app()->user->setFlash('error', 'EAuthException: ' . $e->getMessage());
            $this->redirect('/login');
        }
    }

    public function actionRegister()
    {
        $authData = $this->service->getAuthData();

        if ($authData === null || Yii::app()->user->isAuthenticated()) {
            $this->redirect(Yii::app()->user->returnUrl);
        }

        $module = Yii::app()->getModule('user');

        if ($module->registrationDisabled) {
            throw new CHttpException(404, Yii::t('UserModule.user', 'requested page was not found!'));
        }

        $form = new RegistrationForm;

        $event = new CModelEvent($form);

        $module->onBeginRegistration($event);

        if (Yii::app()->getRequest()->getIsPostRequest()) {
            if (!isset($authData['email']) &&
                Yii::app()->userManager->isUserExist($_POST['RegistrationForm']['email'])
            ) {
                Yii::app()->user->setFlash(
                    YFlashMessages::INFO_MESSAGE,
                    Yii::t(
                        'SocialModule.social',
                        'Аккаунт с таким адресом уже существует! Войдите если хотите присоединить эту социальную сеть к своему аккаунту.'
                    )
                );
                $this->redirect(array('/social/connect', 'service' => $this->service->getServiceName()));
            }

            $password = Yii::app()->userManager->hasher->generateRandomPassword();
            $form->setAttributes(
                array(
                    'nick_name' => $_POST['RegistrationForm']['nick_name'],
                    'email' => isset($authData['email']) ? $authData['email'] : $_POST['RegistrationForm']['email'],
                    'password' => $password,
                    'cPassword' => $password,
                )
            );

            if ($form->validate()) {

                $transaction = Yii::app()->db->beginTransaction();

                try {
                    $user = new User;
                    $data = $form->getAttributes();
                    unset($data['cPassword'], $data['verifyCode']);
                    $user->setAttributes($data);
                    $user->hash = Yii::app()->userManager->hasher->generateRandomPassword();

                    if ($user->save() && ($token = Yii::app()->userManager->tokenStorage->createAccountActivationToken(
                            $user
                        )) !== false
                    ) {

                        $social = new SocialUser();
                        $social->user_id = $user->id;
                        $social->provider = $authData['service'];
                        $social->uid = $authData['uid'];

                        if ($social->save()) {
                            Yii::log(
                                Yii::t(
                                    'UserModule.user',
                                    'Account {nick_name} was created',
                                    array('{nick_name}' => $user->nick_name)
                                ),
                                CLogger::LEVEL_INFO,
                                UserModule::$logCategory
                            );

                            Yii::app()->notify->send(
                                $user,
                                Yii::t(
                                    'UserModule.user',
                                    'Registration on {site}',
                                    array('{site}' => Yii::app()->getModule('yupe')->siteName)
                                ),
                                '//user/email/needAccountActivationEmail',
                                array(
                                    'token' => $token
                                )
                            );

                            $transaction->commit();

                            Yii::app()->user->setFlash(
                                YFlashMessages::SUCCESS_MESSAGE,
                                Yii::t('UserModule.user', 'Account was created! Check your email!')
                            );

                            $this->redirect(array($module->registrationSuccess));
                        }
                    }
                    throw new CException(Yii::t('UserModule.user', 'Error creating account!'));
                } catch (Exception $e) {

                    Yii::log(
                        Yii::t(
                            'UserModule.user',
                            'Error {error} account creating!',
                            array('{error}' => $e->__toString())
                        ),
                        CLogger::LEVEL_INFO,
                        UserModule::$logCategory
                    );

                    $transaction->rollback();

                    Yii::app()->user->setFlash(
                        YFlashMessages::ERROR_MESSAGE,
                        Yii::t('UserModule.user', 'Error creating account!')
                    );

                }
            }
        }

        $this->render('register', array('model' => $form, 'module' => $module));
    }

    public function actionConnect()
    {
        $authData = $this->service->getAuthData();

        if (Yii::app()->user->isAuthenticated()) {
            $this->redirect(Yii::app()->user->returnUrl);
        }

        $badLoginCount = Yii::app()->authenticationManager->getBadLoginCount(Yii::app()->user);

        $scenario = $badLoginCount > 3 ? 'loginLimit' : '';

        $form = new LoginForm($scenario);

        if (Yii::app()->getRequest()->getIsPostRequest() && !empty($_POST['LoginForm'])) {

            $form->setAttributes(Yii::app()->request->getPost('LoginForm'));

            if ($form->validate() && Yii::app()->authenticationManager->login(
                    $form,
                    Yii::app()->user,
                    Yii::app()->request
                )
            ) {

                $social = new \SocialUser();
                $social->user_id = Yii::app()->user->getId();
                $social->provider = $authData['service'];
                $social->uid = $authData['uid'];

                if ($social->save()) {
                    Yii::app()->user->setFlash(
                        YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t(
                            'SocialModule.social',
                            'Социальная сеть подключена к вашему аккаунту, теперь вы можете использовать ее для входа.'
                        )
                    );

                    $module = Yii::app()->getModule('user');

                    $redirect = (Yii::app()->user->isSuperUser() && $module->loginAdminSuccess)
                        ? array($module->loginAdminSuccess)
                        : array($module->loginSuccess);

                    Yii::app()->authenticationManager->setBadLoginCount(Yii::app()->user, 0);

                    $this->redirect(Yii::app()->user->getReturnUrl($redirect));
                }
            } else {

                $form->addError('hash', Yii::t('UserModule.user', 'Email or password was typed wrong!'));

                Yii::app()->authenticationManager->setBadLoginCount(Yii::app()->user, $badLoginCount + 1);

            }
        }

        $this->render('connect', array('authData' => $authData, 'model' => $form));
    }
}