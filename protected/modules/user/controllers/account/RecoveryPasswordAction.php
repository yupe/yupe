<?php
class RecoveryPasswordAction extends CAction
{
    // сброс пароля
    public function run($code)
    {
        if (Yii::app()->user->isAuthenticated())
            $this->controller->redirect(Yii::app()->user->returnUrl);

        $recovery = RecoveryPassword::model()->with('user')->find('code = :code', array(':code' => $code));

        if (!$recovery)
        {
            Yii::log(
                Yii::t('UserModule.user', 'Код восстановления пароля {code} не найден!', array('{code}' => $code)),
                CLogger::LEVEL_ERROR, UserModule::$logCategory
            );
            Yii::app()->user->setFlash(
                YFlashMessages::ERROR_MESSAGE,
                Yii::t('UserModule.user', 'Код восстановления пароля не найден! Попробуйте еще раз!')
            );

            $this->controller->redirect(array('/user/account/recovery'));
        }

        $module = Yii::app()->getModule('user');

        // автоматическое восстановление пароля
        if ($module->autoRecoveryPassword)
        {
            $newPassword = User::model()->generateRandomPassword();
            $recovery->user->password = User::model()->hashPassword($newPassword, $recovery->user->salt);
            $transaction = Yii::app()->db->beginTransaction();
            try
            {
                if ($recovery->user->save())
                {
                    if (RecoveryPassword::model()->deleteAll('user_id = :user_id', array(':user_id' => $recovery->user->id)))
                    {
                        $transaction->commit();

                        Yii::app()->mailMessage->raiseMailEvent($module->passwordSuccessRecoveryMailEvent, array(
                                '{from_mail}' => $module->notifyEmailFrom,
                                '{to_mail}' => $recovery->user->email,
                                '{site}' => CHtml::encode(Yii::app()->name),
                                '{login_url}'  => Yii::app()->createAbsoluteUrl('/user/account/login'),
                                '{password}' => $newPassword,
                            ));

                        Yii::app()->user->setFlash(
                            YFlashMessages::NOTICE_MESSAGE,
                            Yii::t('UserModule.user', 'Новый пароль отправлен Вам на email!')
                        );
                        Yii::log(
                            Yii::t('UserModule.user', 'Успешное восстановление пароля!'),
                            CLogger::LEVEL_ERROR, UserModule::$logCategory
                        );

                        $this->controller->redirect(array('/user/account/login'));
                    }
                }
            }
            catch (CDbException $e)
            {
                $transaction->rollback();

                Yii::app()->user->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    Yii::t('UserModule.user', 'Ошибка при смене пароля!')
                );
                Yii::log(
                    Yii::t('UserModule.user', 'Ошибка при автоматической смене пароля {error}!', array('{error}' => $e->getMessage())),
                    CLogger::LEVEL_ERROR, UserModule::$logCategory
                );
                $this->controller->redirect(array('/user/account/recovery'));
            }
        }

        // выбор своего пароля
        $changePasswordForm = new ChangePasswordForm;

        // если отправили фому с новым паролем
        if (Yii::app()->request->isPostRequest && !empty($_POST['ChangePasswordForm']))
        {
            $changePasswordForm->setAttributes($_POST['ChangePasswordForm']);

            if ($changePasswordForm->validate())
            {
                $transaction = Yii::app()->db->beginTransaction();
                try
                {
                    // смена пароля пользователя
                    $recovery->user->password = User::model()->hashPassword($changePasswordForm->password, $recovery->user->salt);
                    // удалить все запросы на восстановление для данного пользователя
                    if ($recovery->user->save())
                    {
                        if (RecoveryPassword::model()->deleteAll('user_id = :user_id', array(':user_id' => $recovery->user->id)))
                        {
                            $transaction->commit();

                            Yii::app()->user->setFlash(
                                YFlashMessages::NOTICE_MESSAGE,
                                Yii::t('UserModule.user', 'Пароль изменен!')
                            );
                            Yii::log(
                                Yii::t('UserModule.user', 'Успешная смена пароля для пользоателя {user}!', array('{user}' => $recovery->user->id)),
                                CLogger::LEVEL_INFO, UserModule::$logCategory
                            );

                            Yii::app()->mailMessage->raiseMailEvent($module->passwordSuccessRecovery, array(
                                    '{from_mail}' => $module->notifyEmailFrom,
                                    '{to_mail}' => $recovery->user->email,
                                    '{site}' => CHtml::encode(Yii::app()->name),
                                    '{login_url}'  => Yii::app()->createAbsoluteUrl('/user/account/login'),
                                    '{password}' => $newPassword,
                                ));
                            $this->controller->redirect(array('/user/account/login'));
                        }
                    }
                }
                catch (CDbException $e)
                {
                    $transaction->rollback();

                    Yii::app()->user->setFlash(
                        YFlashMessages::ERROR_MESSAGE,
                        Yii::t('UserModule.user', 'Ошибка при смене пароля!')
                    );
                    Yii::log(
                        Yii::t('Ошибка при смене пароля {error}!', array('{error}' => $e->getMessage())),
                        CLogger::LEVEL_ERROR, UserModule::$logCategory
                    );
                    $this->controller->redirect(array('/user/account/recovery'));
                }
            }
        }
        $this->controller->render('changePassword', array('model' => $changePasswordForm));
    }
}