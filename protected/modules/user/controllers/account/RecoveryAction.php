<?php
class RecoveryAction extends CAction
{
    public function run()
    {
        if (Yii::app()->user->isAuthenticated())
            $this->controller->redirect(Yii::app()->user->returnUrl);

        $form = new RecoveryForm;

        if (Yii::app()->request->isPostRequest && isset($_POST['RecoveryForm']))
        {
            $module = Yii::app()->getModule('user');

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
                            Yii::t('UserModule.user', 'Заявка на автоматическое восстановление пароля.'),
                            CLogger::LEVEL_INFO, UserModule::$logCategory
                        );
                        Yii::app()->user->setFlash(
                            YFlashMessages::NOTICE_MESSAGE,
                            Yii::t('UserModule.user', 'На указанный email отправлено письмо с инструкцией по восстановлению пароля!')
                        );

                        Yii::app()->mailMessage->raiseMailEvent($module->passwordRecoveryMailEvent, array(
                                '{from_mail}' => $module->notifyEmailFrom,
                                '{to_mail}' => $user->email,
                                '{site}' => CHtml::encode(Yii::app()->name),
                                '{url}'  => Yii::app()->createAbsoluteUrl('/user/account/recoveryPassword', array('code' => $recovery->code)),
                                '{link}' => CHtml::link(Yii::t('UserModule.user','ссылке'), array('/user/account/recoveryPassword', 'code' => $recovery->code)),
                            ));

                        $this->controller->redirect(array('/user/account/login'));
                    }
                    else
                    {
                        Yii::log(
                            Yii::t('UserModule.user', 'Ощибка при создании заявки на автоматическое восстановление пароля'),
                            CLogger::LEVEL_ERROR, UserModule::$logCategory
                        );
                        Yii::app()->user->setFlash(
                            YFlashMessages::ERROR_MESSAGE,
                            Yii::t('UserModule.user', 'При восстановлении пароля произошла ошибка! Повторите попытку позже!')
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
                            Yii::t('UserModule.user', 'Заявка на восстановление пароля.'),
                            CLogger::LEVEL_INFO, UserModule::$logCategory
                        );
                        Yii::app()->user->setFlash(
                            YFlashMessages::NOTICE_MESSAGE,
                            Yii::t('UserModule.user', 'На указанный email отправлено письмо с инструкцией по восстановлению пароля!')
                        );

                        // отправить email уведомление
                        Yii::app()->mailMessage->raiseMailEvent($module->passwordAutoRecoveryMailEvent, array(
                                '{from_mail}' => $module->notifyEmailFrom,
                                '{to_mail}' => $user->email,
                                '{site}' => CHtml::encode(Yii::app()->name),
                                '{url}'  => Yii::app()->createAbsoluteUrl('/user/account/recoveryPassword', array('code' => $recovery->code)),
                                '{link}' => CHtml::link(Yii::t('UserModule.user','ссылке'), array('/user/account/recoveryPassword', 'code' => $recovery->code)),
                            ));

                        $this->controller->redirect(array('/user/account/recovery'));
                    }
                    else
                    {
                        Yii::app()->user->setFlash(
                            YFlashMessages::ERROR_MESSAGE,
                            Yii::t('UserModule.user', 'При восстановлении пароля произошла ошибка!')
                        );
                        Yii::log(
                            Yii::t('UserModule.user', 'При восстановлении пароля произошла ошибка!'),
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