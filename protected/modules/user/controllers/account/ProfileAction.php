<?php
class ProfileAction extends CAction
{
    public function run()
    {
        $form = new ProfileForm;

        if (!Yii::app()->user->isAuthenticated())
            $this->controller->redirect(array(Yii::app()->user->loginUrl));

        $user = Yii::app()->user->profile;
        $form->setAttributes($user->attributes);
        $form->password = $form->cPassword = null;

        $module = Yii::app()->getModule('user');

        $event = new CModelEvent($this->controller);
        $module->onBeginProfile($event);

        if (Yii::app()->request->isPostRequest && !empty($_POST['ProfileForm']))
        {
            $form->setAttributes($_POST['ProfileForm']);


            if ($form->validate())
            {
                // скопируем данные формы
                $data = $form->getAttributes();
                $newPass = isset($data['password']) ? $data['password'] : null;
                unset($data['password']);

                $orgMail = $user->email;
                $user->setAttributes($data);

                if ($newPass)
                {
                    $user->salt     = $user->generateSalt();
                    $user->password = $user->hashPassword($newPass, $user->salt);
                }

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

                if (!$form->hasErrors())
                {

                    Yii::log(
                        Yii::t('UserModule.user', "Изменен профиль учетной запись #{id}-{nick_name}!", array(
                            '{id}'        => $user->getId(),
                            '{nick_name}' => $user->nick_name,
                        )),
                        CLogger::LEVEL_INFO, UserModule::$logCategory
                    );
                    Yii::app()->user->setFlash(
                        YFlashMessages::NOTICE_MESSAGE,
                        Yii::t('UserModule.user', 'Ваш профиль успешно изменен!')
                    );

                    if ($module->emailAccountVerification && ($orgMail != $form->email))
                    {
                        // отправить email с сообщением о подтверждении мыла

                        $user->email_confirm = User::EMAIL_CONFIRM_NO;
                        $user->activate_key  = $user->generateActivationKey();

                        $emailBody = $this->controller->renderPartial('needEmailActivationEmail', array('model' => $user), true);
                        Yii::app()->mail->send(
                            $module->notifyEmailFrom,
                            $user->email,
                            Yii::t('UserModule.user', 'Подтверждение нового e-mail адреса на сайте {site} !', array('{site}' => Yii::app()->name)),
                            $emailBody
                        );

                        Yii::app()->user->setFlash(
                            YFlashMessages::NOTICE_MESSAGE,
                            Yii::t('UserModule.user', 'Вам необходимо продтвердить новый e-mail, проверьте почту!')
                        );
                    }
                    // Сохраняем профиль
                    $user->save(false);

                    // И дополнительные профили, если они есть
                    if (is_array($this->controller->module->profiles))
                    {
                        foreach ($this->controller->module->profiles as $k => $p)
                            $p->save(false);
                    }

                    $this->controller->redirect(array('/user/account/profile'));
                }
                else
                    Yii::log(
                        Yii::t('UserModule.user', "Ошибка при сохранении профиля! #{id}", array('{id}' => $user->getId())),
                        CLogger::LEVEL_ERROR, UserModule::$logCategory
                     );
            }
        }
        $this->controller->render('profile', array('model' => $form, 'module' => $module));
    }
}