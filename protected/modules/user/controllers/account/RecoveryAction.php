<?php
class RecoveryAction extends CAction
{
    public function run()
    {
        $form = new RecoveryForm;

        if (Yii::app()->request->isPostRequest && isset($_POST['RecoveryForm']))
        {
            $form->setAttributes($_POST['RecoveryForm']);

            if ($form->validate())
            {         
                $user = $form->getUser();

                // если пароль должен быть сгенерирован автоматически
                if (Yii::app()->getModule('user')->autoRecoveryPassword)
                {
                    $recovery = new RecoveryPassword;

                    $recovery->setAttributes(array(
                                                  'user_id' => $user->id,
                                                  'code' => $recovery->generateRecoveryCode($user->id)
                                             ));

                    if ($recovery->save())
                    {
                        // отправить письмо с сылкой на сброс пароля
                        Yii::log(Yii::t('user', 'Заявка на автоматическое восстановление пароля.'), CLogger::LEVEL_INFO, UserModule::$logCategory);
                        Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('user', 'На указанный email отправлено письмо с инструкцией по восстановлению пароля!'));
                        $emailBody = $this->controller->renderPartial('passwordAutoRecoveryEmail', array('model' => $recovery), true);
                        Yii::app()->mail->send(Yii::app()->getModule('user')->notifyEmailFrom, $user->email, Yii::t('user', 'Восстановление пароля!'), $emailBody);
                        $this->controller->redirect(array('/user/account/login'));
                    }
                    else
                    {                        
                        Yii::log(Yii::t('user', 'Ощибка при создании заявки на автоматическое восстановление пароля'), CLogger::LEVEL_ERROR, UserModule::$logCategory);
                        Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE, Yii::t('user', 'При восстановлении пароля произошла ошибка! Повторите попытку позже!!!'));
                        $this->controller->redirect(array('/user/account/recovery'));
                    }
                }
                else
                {
                    $recovery = new RecoveryPassword;

                    $recovery->setAttributes(array(
                                                  'user_id' => $user->id,
                                                  'code' => $recovery->generateRecoveryCode($user->id)
                                             ));

                    if ($recovery->save())
                    {
                        Yii::log(Yii::t('user', 'Заявка на восстановление пароля.'), CLogger::LEVEL_INFO, UserModule::$logCategory);
                        Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('user', 'На указанный email отправлено письмо с инструкцией по восстановлению пароля!'));
                        // отправить email уведомление
                        $emailBody = $this->controller->renderPartial('passwordRecoveryEmail', array('model' => $recovery), true);
                        Yii::app()->mail->send(Yii::app()->getModule('user')->notifyEmailFrom, $user->email, Yii::t('user', 'Восстановление пароля!'), $emailBody);
                        $this->controller->redirect(array('/user/account/recovery'));
                    }
                    else
                    {
                        Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE, Yii::t('user', 'При восстановлении пароля произошла ошибка!'));
                        Yii::log($e->getMessage(), CLogger::LEVEL_ERROR, UserModule::$logCategory);
                        $this->controller->redirect(array('/user/account/recovery'));
                    }
                }
                
            }
        }

        $this->controller->render('recovery', array('model' => $form));
    }
}