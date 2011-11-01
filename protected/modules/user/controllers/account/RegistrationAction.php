<?php
class RegistrationAction extends CAction
{
    public function run()
    {
        $form = new RegistrationForm;

        if (Yii::app()->request->isPostRequest && !empty($_POST['RegistrationForm']))
        {
            $module = Yii::app()->getModule('user');

            $form->setAttributes($_POST['RegistrationForm']);

            // проверка по "черным спискам"
            
            // проверить на email
            if (!$module->isAllowedEmail($form->email))
            {
                // перенаправить на экшн для фиксации невалидных email-адресов
                $this->controller->redirect(array(Yii::app()->getModule('user')->invalidEmailAction));
            }

            if (!$module->isAllowedIp(Yii::app()->request->userHostAddress))
            {
                // перенаправить на экшн для фиксации невалидных ip-адресов
                $this->controller->redirect(array(Yii::app()->getModule('user')->invalidIpAction));
            }

            if ($form->validate())
            {                
                // если требуется активация по email
                if ($module->emailAccountVerification)
                {
                    $registration = new User;

                    // скопируем данные формы
                    $registration->setAttributes($form->getAttributes());

                    if ($registration->save())
                    {
                        // отправка email с просьбой активировать аккаунт
                        $mailBody = $this->controller->renderPartial('needAccountActivationEmail', array('model' => $registration), true);
                        Yii::app()->mail->send($module->notifyEmailFrom, $registration->email, Yii::t('user', 'Регистрация на сайте {site} !',array('{site}' => Yii::app()->name )), $mailBody);
                        // запись в лог о создании учетной записи
                        Yii::log(Yii::t('user', "Создана учетная запись {nick_name}!", array('{nick_name}' => $registration->nick_name)), CLogger::LEVEL_INFO, UserModule::$logCategory);
                        Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('user', 'Учетная запись создана! Инструкции по активации аккаунта отправлены Вам на email!'));
                        $this->controller->refresh();
                    }
                    else
                    {
                        $form->addErrors($registration->getErrors());

                        Yii::log(Yii::t('user', "Ошибка при создании  учетной записи!"), CLogger::LEVEL_ERROR, UserModule::$logCategory);     
                    }
                }
                else
                {                    
                    // если активации не требуется - сразу создаем аккаунт
                    $user = new User;                    

                    $user->createAccount($form->nick_name, $form->email, $form->password, null , User::STATUS_ACTIVE, User::EMAIL_CONFIRM_YES);

                    if ($user && !$user->hasErrors())
                    {
                        Yii::log(Yii::t('user', "Создана учетная запись {nick_name} без активации!", array('{nick_name}' => $user->nick_name)), CLogger::LEVEL_INFO, UserModule::$logCategory);

                        // отправить email с сообщением о успешной регистрации
                        $emailBody = $this->controller->renderPartial('accountCreatedEmail', array('model' => $user), true);

                        Yii::app()->mail->send($module->notifyEmailFrom, $user->email, Yii::t('user', 'Регистрация на сайте {site} !', array('{site}' => Yii::app()->name)), $emailBody);

                        Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('user', 'Учетная запись создана! Пожалуйста, авторизуйтесь!'));

                        $this->controller->redirect(array('/user/account/login/'));
                    }
                    else
                    {
                        $form->addErrors($user->getErrors());

                        Yii::log(Yii::t('user', "Ошибка при создании  учетной записи без активации!"), CLogger::LEVEL_ERROR, UserModule::$logCategory);
                    }                                       
                }
            }
        }

        $this->controller->render('registration', array('model' => $form));
    }
}