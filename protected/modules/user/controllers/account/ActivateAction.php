<?php
class ActivateAction extends CAction
{
    public function run()
    {
        $email = trim(Yii::app()->request->getQuery('email'));
        $code = trim(Yii::app()->request->getQuery('code'));

        if (!$email || !$code)
        {
            Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE, Yii::t('user', 'Ошибка активации! Переданы не все параметры! Попробуете зарегистрироваться вновь?'));
            $this->controller->redirect(array(Yii::app()->getModule('user')->accountActivationFailure));
        }

        // пытаемся сделать выборку из таблицы регистраций
        $registration = Registration::model()->find('email = :email AND code = :code', array(
                                                                                            ':email' => $email,
                                                                                            ':code' => $code
                                                                                       ));

        if (is_null($registration))
        {
            Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE, Yii::t('user', 'Ошибка активации! Возможно данный аккаунт уже активирован! Попробуете зарегистрироваться вновь?'));
            $this->controller->redirect(array(Yii::app()->getModule('user')->accountActivationFailure));
        }

        // процедура активации

        // проверить параметры пользователя по "черным спискам"
        if (!Yii::app()->getModule('user')->isAllowedIp())
        {
            // перенаправить на экшн для фиксации невалидных ip адресов
            $this->controller->redirect(array(Yii::app()->getModule('user')->invalidIpAction));
        }

        // проверить на email
        if (!Yii::app()->getModule('user')->isAllowedEmail($registration->email))
        {
            // перенаправить на экшн для фиксации невалидных ip адресов
            $this->controller->redirect(array(Yii::app()->getModule('user')->invalidEmailAction));
        }

        // все проверки прошли - активируем аккаунт

        $transaction = Yii::app()->db->beginTransaction();

        try
        {
            // удалить запись из таблички регистраций
            $registration->delete();

            // создать запись в таблице пользователей
            $user = new User();

            $user->setAttributes(array(
                                      'nick_name' => $registration->nick_name,
                                      'email' => $registration->email,
                                      'password' => $registration->password,
                                      'salt' => $registration->salt,
                                      'registration_date' => $registration->creation_date,
                                      'registration_ip' => $registration->ip
                                 ));


            if ($user->save())
            {
                // для нового пользователя создать пустой профиль
                $profile = new Profile();

                $profile->setAttributes(array(
                                             'user_id' => $user->id
                                        ));

                if ($profile->save())
                {
                    $transaction->commit();
                    Yii::log(Yii::t('user', "Активирован аккаунт code => {code}, email => {email}!", array('{code}' => $code, '{email}' => $email)), CLogger::LEVEL_INFO, UserModule::$logCategory);
                    Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('user', 'Вы успешно активировали аккаунт! Теперь Вы можете войти!'));
                    // отправить сообщение о активации аккаунта
                    $emailBody = $this->controller->renderPartial('application.modules.user.views.email.accountActivatedEmail', array('model' => $user), true);
                    Yii::app()->mail->send(Yii::app()->getModule('user')->notifyEmailFrom, $user->email, Yii::t('user', 'Аккаунт активирован!'), $emailBody);
                    $this->controller->redirect(array(Yii::app()->getModule('user')->accountActivationSuccess));
                }
            }

            throw new CDbException(Yii::t('user', 'При активации аккаунта произошла ошибка!'));

        }
        catch (CDbException $e)
        {
            $transaction->rollback();
            Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE, Yii::t('user', 'При активации аккаунта произошла ошибка! Попробуйте позже!' . $e->getMessage()));
            Yii::log(Yii::t('user', "При активации аккаунта (code => {code}, email => {email}) произошла ошибка {error}!", array('{email}' => $email, '{code}' => $code, '{error}' => $e->getMessage())), CLogger::LEVEL_ERROR, UserModule::$logCategory);
            $this->controller->redirect(array(Yii::app()->getModule('user')->accountActivationFailure));
        }
    }
}

?>