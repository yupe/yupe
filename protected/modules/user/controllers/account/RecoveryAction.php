<?php
/**
 * Экшн, отвечающий за запрос восстановления пароля пользователя
 *
 * @category YupeComponents
 * @package  yupe.modules.user.controllers.account
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 *
 **/
class RecoveryAction extends CAction
{
    public function run()
    {
        $module = Yii::app()->getModule('user');

        if ($module->recoveryDisabled){
        	throw new CHttpException(404, Yii::t('UserModule.user', 'requested page was not found!'));
        }

        if (Yii::app()->user->isAuthenticated()){
            $this->controller->redirect(Yii::app()->user->returnUrl);
        }

        $form = new RecoveryForm;

        if (Yii::app()->getRequest()->getIsPostRequest() && isset($_POST['RecoveryForm']))
        {
            $form->setAttributes($_POST['RecoveryForm']);

            if ($form->validate())
            {
                $user = $form->getUser();

                // если пароль должен быть сгенерирован автоматически
                if ($module->autoRecoveryPassword)
                {
                    $recovery = new RecoveryPassword;
                    $recovery->setAttributes(array(
                        'user_id' => $user->id,
                        'code'    => $recovery->generateRecoveryCode($user->id),
                    ));

                    if ($recovery->save())
                    {
                        // отправить письмо с сылкой на сброс пароля
                        Yii::log(
                            Yii::t('UserModule.user', 'Automatic password recovery request'),
                            CLogger::LEVEL_INFO, UserModule::$logCategory
                        );
                        Yii::app()->user->setFlash(
                            YFlashMessages::SUCCESS_MESSAGE,
                            Yii::t('UserModule.user', 'Letter with password recovery instructions was sent on email which you choose during register')
                        );

                        $emailBody = $this->controller->renderPartial('passwordAutoRecoveryEmail', array('model' => $recovery), true);

                        Yii::app()->mail->send($module->notifyEmailFrom, $user->email, Yii::t('UserModule.user', 'Password recovery!'), $emailBody);
                        $this->controller->redirect(array('/user/account/login'));
                    }
                    else
                    {
                        Yii::log(
                            Yii::t('UserModule.user', 'Error when creating automatic password recovering order'),
                            CLogger::LEVEL_ERROR, UserModule::$logCategory
                        );
                        Yii::app()->user->setFlash(
                            YFlashMessages::ERROR_MESSAGE,
                            Yii::t('UserModule.user', 'Password recovery error. Try again later')
                        );
                        $this->controller->redirect(array('/user/account/recovery'));
                    }
                }
                else
                {
                    $recovery = new RecoveryPassword;
                    $recovery->setAttributes(array(
                        'user_id' => $user->id,
                        'code'    => $recovery->generateRecoveryCode($user->id),
                    ));

                    if ($recovery->save())
                    {
                        Yii::log(
                            Yii::t('UserModule.user', 'Password recovery request'),
                            CLogger::LEVEL_INFO, UserModule::$logCategory
                        );
                        Yii::app()->user->setFlash(
                            YFlashMessages::SUCCESS_MESSAGE,
                            Yii::t('UserModule.user', 'Letter with password recovery instructions was sent on email which you choose during register')
                        );

                        // отправить email уведомление
                        $emailBody = $this->controller->renderPartial('passwordRecoveryEmail', array('model' => $recovery), true);

                        Yii::app()->mail->send($module->notifyEmailFrom, $user->email, Yii::t('UserModule.user', 'Password recovery!'), $emailBody);
                        $this->controller->redirect(array('/user/account/recovery'));
                    }
                    else
                    {
                        Yii::app()->user->setFlash(
                            YFlashMessages::ERROR_MESSAGE,
                            Yii::t('UserModule.user', 'Password recovery error.')
                        );
                        Yii::log(
                            Yii::t('UserModule.user', 'Password recovery error.'),
                            CLogger::LEVEL_ERROR, UserModule::$logCategory
                        );
                        $this->controller->redirect(array('/user/account/recovery'));
                    }
                }
            }
        }

        $this->controller->render('recovery', array('model' => $form));
    }
}