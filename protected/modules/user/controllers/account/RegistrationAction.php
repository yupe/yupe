<?php
class RegistrationAction extends CAction
{
    public function run()
    {
        $form = new RegistrationForm;

        if (Yii::app()->user->isAuthenticated())
            $this->controller->redirect(Yii::app()->user->returnUrl);

        $module = Yii::app()->getModule('user');

        $event = new CModelEvent($this->controller);
        $module->onBeginRegistration($event);

        if (Yii::app()->request->isPostRequest && !empty($_POST['RegistrationForm']))
        {
            $form->setAttributes($_POST['RegistrationForm']);

            if ($form->validate())
            {
                $user = new User;

                // скопируем данные формы
                $data = $form->getAttributes();
                unset($data['cPassword'], $data['verifyCode']);

                $user->setAttributes($data);

                // Если есть ошибки в профиле - перекинем их в форму
                if ($user->hasErrors())
                    $form->addErrors($user->getErrors());

                // Если у нас есть дополнительные профили - проверим их
                if (is_array($this->controller->module->profiles))
                {
                    foreach ($this->controller->module->profiles as $p)
                    {
                        if (!$p->validate())
                            $form->addErrors($p->getErrors());
                    }
                }

                // если активации не требуется - сразу создаем аккаунт
                if (!$form->hasErrors())
                {
                    $transaction = Yii::app()->db->beginTransaction();
                    try
                    {
                        $user->salt = $user->generateSalt();
                        $user->password = $user->hashPassword(($user->password === NULL) ? $user->generateRandomPassword() : $user->password, $user->salt);
                        $user->registration_date = date('Y-m-d H:i:s');
                        $user->status = $module->emailAccountVerification?User::STATUS_NOT_ACTIVE:User::STATUS_ACTIVE;
                        $user->email_confirm = User::EMAIL_CONFIRM_NO;
                        $user->registration_ip = $user->activation_ip = Yii::app()->request->userHostAddress;
                        if($user->save())
                        {
                            // Сохраняем дополнительные профили, если они есть
                            if (is_array($this->controller->module->profiles))
                            {
                                foreach ($this->controller->module->profiles as $k => $p)
                                {
                                    $p->user_id=$user->id;
                                    if (!$p->save(false))
                                        throw new CException(Yii::t('UserModule.user', 'При создании профиля {profile} новой учетной записи произошла ошибка! {ps}', array('{profile}'=>$k, '{ps}'=>serialize($p))));
                                }
                            }
                            $transaction->commit();
                        } else
                            throw new CException(Yii::t('UserModule.user', 'При создании новой учетной записи произошла ошибка! {user}', array('{user}'=>serialize($user))));

                    }
                    catch (Exception $e)
                    {
                        $form->addErrors($user->getErrors());
                        $transaction->rollback();
                        $form->addError('', Yii::t('UserModule.user', 'При создании учетной записи произошла ошибка!'));
                    }

                }

                if (!$form->hasErrors() && $user && !$user->hasErrors())
                {
                    if ($module->emailAccountVerification)
                    {
                        // отправка email с просьбой активировать аккаунт
                        Yii::app()->mailMessage->raiseMailEvent($module->registrationActivateMailEvent, array(
                                '{from_mail}' => $module->notifyEmailFrom,
                                '{to_mail}' => $user->email,
                                '{site}' => CHtml::encode(Yii::app()->name),
                                '{url}'  => Yii::app()->createAbsoluteUrl('/user/account/activate', array('key' => $user->activate_key)),
                            ));

                        // запись в лог о создании учетной записи
                        Yii::log(
                            Yii::t('UserModule.user', "Создана учетная запись {nick_name}!", array('{nick_name}' => $user->nick_name)),
                            CLogger::LEVEL_INFO, UserModule::$logCategory
                        );

                        Yii::app()->user->setFlash(
                            YFlashMessages::NOTICE_MESSAGE,
                            Yii::t('UserModule.user', 'Учетная запись создана! Проверьте Вашу почту!')
                        );
                        $this->controller->redirect(array($module->registrationSucess));

                    } else {
                        Yii::log(
                            Yii::t('UserModule.user', "Создана учетная запись {nick_name} без активации!", array('{nick_name}' => $user->nick_name)),
                            CLogger::LEVEL_INFO, UserModule::$logCategory
                        );

                        // отправить email с сообщением о успешной регистрации
                        Yii::app()->mailMessage->raiseMailEvent($module->registrationMailEvent, array(
                                '{from_mail}' => $module->notifyEmailFrom,
                                '{to_mail}' => $user->email,
                                '{site}' => CHtml::encode(Yii::app()->name),
                                '{login_url}'  => Yii::app()->createAbsoluteUrl('/user/account/login'),
                            ));

                        // Автоматически логиним пользователя
                        $login = new LoginForm;
                        $login->email    = $form->email;
                        $login->password = $form->password;
                        $login->authenticate();

                        Yii::app()->user->setFlash(
                            YFlashMessages::NOTICE_MESSAGE,
                            Yii::t('UserModule.user', 'Ваша учетная запись была создана, вы автоматически авторизованы.')
                        );

                        $this->controller->redirect(array($module->registrationSucess));
                    }
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
        $this->controller->render('registration', array('model' => $form, 'module' => $module));
    }
}