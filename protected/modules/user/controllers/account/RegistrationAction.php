<?php
/**
 * Экшн, отвечающий за регистрацию нового пользователя
 *
 * @category YupeComponents
 * @package  yupe.modules.user.controllers.account
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 *
 **/

use yupe\components\WebModule;

class RegistrationAction extends CAction
{
    public function run()
    {
        $module = Yii::app()->getModule('user');

        if ($module->registrationDisabled) {
        	throw new CHttpException(404, Yii::t('UserModule.user', 'requested page was not found!'));
        }

        $form = new RegistrationForm;

        if (Yii::app()->user->isAuthenticated()) {
            $this->controller->redirect(Yii::app()->user->returnUrl);
        }

        $event = new CModelEvent($form);

        $module->onBeginRegistration($event);

        if (($data = Yii::app()->getRequest()->getPost('RegistrationForm')) !== null) {
            
            $form->setAttributes($data);

            if ($form->validate()) {
                
                // если требуется активация по email
                if ($module->emailAccountVerification) {
                    $user = new User;

                    // скопируем данные формы
                    $data = $form->getAttributes();
                    unset($data['cPassword'], $data['verifyCode']);

                    $user->setAttributes($data);
                    
                    $salt = $user->generateRandomPassword();
                    
                    $user->setAttributes(
                        array(
                            'salt'     => $salt,
                            'password' => $user->hashPassword($form->password, $salt),
                        )
                    );

                    $transaction = Yii::app()->db->beginTransaction();

                    try {
                        if ($user->save()) {

                            // запись в лог о создании учетной записи
                            Yii::log(
                                Yii::t('UserModule.user', 'Account {nick_name} was created', array('{nick_name}' => $user->nick_name)),
                                CLogger::LEVEL_INFO, UserModule::$logCategory
                            );

                            $transaction->commit();

                            // отправка email с просьбой активировать аккаунт
                            yupe\components\Token::sendActivation(
                                $user, '//user/account/needAccountActivationEmail'
                            );

                            Yii::app()->user->setFlash(
                                YFlashMessages::SUCCESS_MESSAGE,
                                Yii::t('UserModule.user', 'Account was created! Check your email!')
                            );
                            $this->controller->redirect(array($module->registrationSucess));
                        } else {
                            $form->addErrors($user->getErrors());

                            Yii::log(
                                Yii::t('UserModule.user', 'Error when creating new account!'),
                                CLogger::LEVEL_ERROR, UserModule::$logCategory
                            );
                        }
                    } catch (Exception $e) {
                        Yii::app()->getDb()->getCurrentTransaction() === null || $transaction->rollback();
                        $form->addError('', Yii::t('UserModule.user', 'There is an error when creating user!'));
                        $form->addError('', $e->getMessage());
                    }
                } else {
                    // если активации не требуется - сразу создаем аккаунт
                    $user = new User;

                    $user->createAccount(
                        $form->nick_name,
                        $form->email,
                        $form->password,
                        null,
                        User::STATUS_ACTIVE,
                        User::EMAIL_CONFIRM_NO
                    );

                    if ($user && !$user->hasErrors()) {
                        Yii::log(
                            Yii::t('UserModule.user', 'Account {nick_name} was created without activation', array('{nick_name}' => $user->nick_name)),
                            CLogger::LEVEL_INFO, UserModule::$logCategory
                        );

                        // отправить email с сообщением о успешной регистрации
                        $emailBody = $this->controller->renderPartial('accountCreatedEmail', array('model' => $user), true);

                        Yii::app()->mail->send(
                            $module->notifyEmailFrom,
                            $user->email,
                            Yii::t('UserModule.user', 'Registration on {site}', array('{site}' => Yii::app()->name)),
                            $emailBody
                         );

                        Yii::app()->user->setFlash(
                            YFlashMessages::SUCCESS_MESSAGE,
                            Yii::t('UserModule.user', 'Account was created! Please authorize!')
                        );
                        $this->controller->redirect(array($module->registrationSucess));
                    }
                    else
                    {
                        $form->addErrors($user->getErrors());

                        Yii::log(
                            Yii::t('UserModule.user', 'Error when creating new account without activation!'),
                            CLogger::LEVEL_ERROR, UserModule::$logCategory
                        );
                    }
                }
            }
        }

        $this->controller->render('registration', array('model' => $form, 'module' => $module));
    }
}