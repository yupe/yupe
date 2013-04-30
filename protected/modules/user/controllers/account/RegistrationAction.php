<?php
class RegistrationAction extends CAction
{
    public function run()
    {
        $module = Yii::app()->getModule('user');

        if ($module->registrationDisabled){
        	throw new CHttpException(404, Yii::t('UserModule.user', 'Запрошенная страница не найдена!'));
        }

        $form = new RegistrationForm;

        if (Yii::app()->user->isAuthenticated()){
            $this->controller->redirect(Yii::app()->user->returnUrl);
        }

        $event = new CModelEvent($form);

        $module->onBeginRegistration($event);

        if (Yii::app()->request->isPostRequest && !empty($_POST['RegistrationForm']))
        {
            $form->setAttributes($_POST['RegistrationForm']);

            if ($form->validate())
            {
                // если требуется активация по email
                if ($module->emailAccountVerification)
                {
                    $user = new User;

                    // скопируем данные формы
                    $data = $form->getAttributes();
                    unset($data['cPassword'], $data['verifyCode']);

                    $user->setAttributes($data);
                    $salt = $user->generateRandomPassword();
                    $user->setAttributes(array(
                        'salt'     => $salt,
                        'password' => $user->hashPassword($form->password, $salt),
                    ));

                    $transaction = Yii::app()->db->beginTransaction();
                    try
                    {
                        if ($user->save())
                        {
                            // отправка email с просьбой активировать аккаунт
                            $mailBody = $this->controller->renderPartial('needAccountActivationEmail', array('model' => $user), true);

                            Yii::app()->mail->send(
                                $module->notifyEmailFrom,
                                $user->email,
                                Yii::t('UserModule.user', 'Регистрация на сайте {site} !', array('{site}' => Yii::app()->name)),
                                $mailBody
                            );

                            // запись в лог о создании учетной записи
                            Yii::log(
                                Yii::t('UserModule.user', "Создана учетная запись {nick_name}!", array('{nick_name}' => $user->nick_name)),
                                CLogger::LEVEL_INFO, UserModule::$logCategory
                            );

                            $transaction->commit();

                            Yii::app()->user->setFlash(
                                YFlashMessages::NOTICE_MESSAGE,
                                Yii::t('UserModule.user', 'Учетная запись создана! Проверьте Вашу почту!')
                            );
                            $this->controller->redirect(array($module->registrationSucess));
                        }
                        else
                        {
                            $form->addErrors($user->getErrors());

                            Yii::log(
                                Yii::t('UserModule.user', "Ошибка при создании  учетной записи!"),
                                CLogger::LEVEL_ERROR, UserModule::$logCategory
                            );
                        }
                    }
                    catch (Exception $e)
                    {
                        $transaction->rollback();
                        $form->addError('', Yii::t('UserModule.user', 'При создании учетной записи произошла ошибка!'));
                    }
                }
                else
                {
                    // если активации не требуется - сразу создаем аккаунт
                    $user = new User;

                    $user->createAccount($form->nick_name, $form->email, $form->password, null , User::STATUS_ACTIVE, User::EMAIL_CONFIRM_NO);

                    if ($user && !$user->hasErrors())
                    {
                        Yii::log(
                            Yii::t('UserModule.user', "Создана учетная запись {nick_name} без активации!", array('{nick_name}' => $user->nick_name)),
                            CLogger::LEVEL_INFO, UserModule::$logCategory
                        );

                        // отправить email с сообщением о успешной регистрации
                        $emailBody = $this->controller->renderPartial('accountCreatedEmail', array('model' => $user), true);

                        Yii::app()->mail->send(
                            $module->notifyEmailFrom,
                            $user->email,
                            Yii::t('UserModule.user', 'Регистрация на сайте {site} !', array('{site}' => Yii::app()->name)),
                            $emailBody
                         );

                        Yii::app()->user->setFlash(
                            YFlashMessages::NOTICE_MESSAGE,
                            Yii::t('UserModule.user', 'Учетная запись создана! Пожалуйста, авторизуйтесь!')
                        );
                        $this->controller->redirect(array($module->registrationSucess));
                    }
                    else
                    {
                        $form->addErrors($user->getErrors());

                        Yii::log(
                            Yii::t('UserModule.user', "Ошибка при создании  учетной записи без активации!"),
                            CLogger::LEVEL_ERROR, UserModule::$logCategory
                        );
                    }
                }
            }
        }

        $this->controller->render('registration', array('model' => $form, 'module' => $module));
    }
}