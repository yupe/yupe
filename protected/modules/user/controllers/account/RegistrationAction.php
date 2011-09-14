<?php
class RegistrationAction extends CAction
{
    public function run()
    {
        $form = new RegistrationForm();

        if (Yii::app()->request->isPostRequest && isset($_POST['RegistrationForm'])) {
            $form->setAttributes($_POST['RegistrationForm']);

            // проверка по "черным спискам"
            // проверить на email
            if (!Yii::app()->getModule('user')->isAllowedEmail($form->email)) {
                // перенаправить на экшн для фиксации невалидных ip адресов
                $this->controller->redirect(array(Yii::app()->getModule('user')->invalidEmailAction));
            }

            if (!Yii::app()->getModule('user')->isAllowedIp(Yii::app()->request->userHostAddress)) {
                // перенаправить на экшн для фиксации невалидных ip адресов
                $this->controller->redirect(array(Yii::app()->getModule('user')->invalidIpAction));
            }

            if ($form->validate()) {
                // если требуется активация по email
                if (Yii::app()->getModule('user')->emailAccountVerification) {
                    $registration = new Registration();

                    // скопируем данные формы - они прошли через фильтр trim

                    $registration->setAttributes(array(
                                                      'nickName' => $form->nickName,
                                                      'password' => $form->password,
                                                      'email' => $form->email
                                                 ));

                    if ($registration->save()) {
                        // отправка email с просьбой активировать аккаунт
                        $mailBody = $this->controller->renderPartial('application.modules.user.views.email.needAccountActivationEmail', array('model' => $registration), true);
                        Yii::app()->mail->send(Yii::app()->getModule('user')->notifyEmailFrom, $registration->email, Yii::t('user', 'Регистрация на сайте ' . Yii::app()->name . ' !'), $mailBody);
                        // запись в лог о создании учетной записи
                        Yii::log(Yii::t('user', "Создана учетная запись {nickName}!", array('{nickName}' => $registration->nickName)), CLogger::LEVEL_INFO, UserModule::$logCategory);
                        Yii::app()->user->setFlash(FlashMessagesWidget::NOTICE_MESSAGE, Yii::t('user', 'Учетная запись создана! Инструкции по активации аккаунта отправлены Вам на email!'));
                        $this->controller->refresh();
                    }
                    else
                    {
                        $form->addErrors($registration->getErrors());
                        Yii::log(Yii::t('user', "Ошибка при создании  учетной записи"), CLogger::LEVEL_ERROR, UserModule::$logCategory);
                        $this->controller->render('registration', array('model' => $form));
                        return false;
                    }
                }
                else
                {
                    // если активации не требуется - сразу создаем аккаунт
                    $user = User::model()->createAccount($form->nickName, $form->email, null, $form->password);

                    if (is_object($user) && !$user->hasErrors()) {
                        Yii::log(Yii::t('user', "Создана учетная запись {nickName} без активации!", array('{nickName}' => $user->nickName)), CLogger::LEVEL_INFO, UserModule::$logCategory);
                        // отправить email с сообщением о успешной регистрации
                        $emailBody = $this->controller->renderPartial('application.modules.user.views.email.accountCreatedEmail', array('model' => $user), true);
                        Yii::app()->mail->send(Yii::app()->getModule('user')->notifyEmailFrom, $user->email, Yii::t('user', 'Регистрация на сайте {site} !', array('{site}' => Yii::app()->name)), $emailBody);
                        Yii::app()->user->setFlash(FlashMessagesWidget::NOTICE_MESSAGE, Yii::t('user', 'Учетная запись создана! Авторизуйтесь!'));
                        $this->controller->redirect(array('/user/account/login'));
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

?>
