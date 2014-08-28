<?php
namespace application\modules\social\controllers;

use yupe\components\controllers\FrontController;
use yupe\widgets\YFlashMessages;
use application\modules\social\components\UserIdentity;
use application\modules\social\models\SocialUser;

use Yii;
use EAuthException;
use CHttpException;
use User;
use RegistrationForm;
use LoginForm;

class UserController extends FrontController
{
    protected $service;

    public function actions()
    {
        return array(
            'captcha' => array(
                'class'     => 'yupe\components\actions\YCaptchaAction',
                'backColor' => 0xFFFFFF,
                'testLimit' => 1,
                'minLength' => Yii::app()->getModule('user')->minCaptchaLength,
            ),
        );
    }

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

                    Yii::app()->getUser()->setFlash(
                        YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t('SocialModule.social', 'Вы успешно вошли!')
                    );

                    $module = Yii::app()->getModule('user');

                    $redirect = (Yii::app()->getUser()->isSuperUser() && $module->loginAdminSuccess)
                        ? array($module->loginAdminSuccess)
                        : array($module->loginSuccess);

                    Yii::app()->authenticationManager->setBadLoginCount(Yii::app()->getUser(), 0);

                    $this->redirect(Yii::app()->getUser()->getReturnUrl($redirect));
                }

                if ($this->service->hasAttribute('email') && Yii::app()->userManager->isUserExist(
                        $this->service->email
                    )
                ) {

                    Yii::app()->getUser()->setFlash(
                        YFlashMessages::INFO_MESSAGE,
                        Yii::t(
                            'SocialModule.social',
                            'Аккаунт с таким адресом уже существует! Войдите если хотите присоединить эту социальную сеть к своему аккаунту.'
                        )
                    );

                    $this->redirect(array('/social/connect', 'service' => $this->service->getServiceName()));
                }

                Yii::app()->getUser()->setFlash(
                    YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t(
                        'SocialModule.social',
                        'Вы успешно авторизовались, пожалуйста, завершите регистрацию!'
                    )
                );

                $this->redirect(array('/social/register', 'service' => $this->service->getServiceName()));
            }
            $this->redirect('/login');
        } catch (EAuthException $e) {
            Yii::app()->getUser()->setFlash('error', 'EAuthException: ' . $e->getMessage());
            $this->redirect('/login');
        }
    }

    public function actionRegister()
    {
        $authData = $this->service->getAuthData();

        if (null === $authData || Yii::app()->getUser()->isAuthenticated()) {
            $this->redirect(Yii::app()->getUser()->returnUrl);
        }

        $module = Yii::app()->getModule('user');

        if ($module->registrationDisabled) {
            throw new CHttpException(404, Yii::t('SocialModule.social', 'requested page was not found!'));
        }

        $form = new RegistrationForm();

        $form->disableCaptcha = true;

        if (Yii::app()->getRequest()->getIsPostRequest() && !empty($_POST['RegistrationForm'])) {

            $form->setAttributes(Yii::app()->getRequest()->getPost('RegistrationForm'));

            if (!isset($authData['email']) && Yii::app()->userManager->isUserExist($form->email)) {

                Yii::app()->getUser()->setFlash(
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
                    'password'   => $password,
                    'cPassword'  => $password,
                    'verifyCode' => null
                )
            );

            if ($form->validate()) {

                if ($user = Yii::app()->userManager->createUser($form)) {

                    $social = new SocialUser();
                    $social->user_id = $user->id;
                    $social->provider = $authData['service'];
                    $social->uid = $authData['uid'];
                    if ($social->save()) {
                        Yii::app()->getUser()->setFlash(
                            YFlashMessages::SUCCESS_MESSAGE,
                            Yii::t(
                                'SocialModule.social',
                                'Регистрация прошла успешно!'
                            )
                        );

                        $this->redirect(array($module->registrationSuccess));
                    }
                }
            }

            $form->addError('', Yii::t('SocialModule.social', 'Error!'));
        }

        $this->render('register', array('model' => $form, 'module' => $module));
    }

    public function actionConnect()
    {
        if (Yii::app()->getUser()->isAuthenticated()) {
            $this->redirect(Yii::app()->getUser()->returnUrl);
        }

        $authData = $this->service->getAuthData();

        $badLoginCount = Yii::app()->authenticationManager->getBadLoginCount(Yii::app()->getUser());

        $scenario = $badLoginCount > 3 ? 'loginLimit' : '';

        $form = new LoginForm($scenario);

        if (Yii::app()->getRequest()->getIsPostRequest() && !empty($_POST['LoginForm'])) {

            $form->setAttributes(Yii::app()->getRequest()->getPost('LoginForm'));

            if ($form->validate() && Yii::app()->authenticationManager->login(
                    $form,
                    Yii::app()->getUser(),
                    Yii::app()->getRequest()
                )
            ) {

                $social = new SocialUser();
                $social->user_id = Yii::app()->getUser()->getId();
                $social->provider = $authData['service'];
                $social->uid = $authData['uid'];

                if ($social->save()) {
                    Yii::app()->getUser()->setFlash(
                        YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t(
                            'SocialModule.social',
                            'Социальная сеть подключена к вашему аккаунту, теперь вы можете использовать ее для входа.'
                        )
                    );

                    $module = Yii::app()->getModule('user');

                    $redirect = (Yii::app()->getUser()->isSuperUser() && $module->loginAdminSuccess)
                        ? array($module->loginAdminSuccess)
                        : array($module->loginSuccess);

                    Yii::app()->authenticationManager->setBadLoginCount(Yii::app()->getUser(), 0);

                    $this->redirect(Yii::app()->getUser()->getReturnUrl($redirect));
                }
            } else {

                $form->addError('hash', Yii::t('SocialModule.social', 'Email or password was typed wrong!'));

                Yii::app()->authenticationManager->setBadLoginCount(Yii::app()->getUser(), $badLoginCount + 1);

            }
        }

        $this->render('connect', array('authData' => $authData, 'model' => $form));
    }
}
