<?php
class ActivateAction extends CAction
{
    public function run($code)
    {       
        $code = trim($code);

        // пытаемся сделать выборку из таблицы регистраций
        $registration = Registration::model()->find('code = :code', array(':code' => $code));

        if (is_null($registration))
        {
            Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE, Yii::t('user', 'Ошибка активации! Возможно данный аккаунт уже активирован! Попробуете зарегистрироваться вновь?'));
            $this->controller->redirect(array(Yii::app()->getModule('user')->accountActivationFailure));
        }

        // процедура активации

        // проверить параметры пользователя по "черным спискам"
        if (!Yii::app()->getModule('user')->isAllowedIp(Yii::app()->request->userHostAddress))
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
            // создать запись в таблице пользователей и удалить запись в таблице регистраций

            $user = new User;

            $user->setAttributes($registration->getAttributes());

            if ($registration->delete() && $user->save())
            {                
                $transaction->commit();

                Yii::log(Yii::t('user', "Активирован аккаунт с code = {code}!", array('{code}' => $code)), CLogger::LEVEL_INFO, UserModule::$logCategory);

                Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('user', 'Вы успешно активировали аккаунт! Теперь Вы можете войти!'));

                // отправить сообщение о активации аккаунта
                $emailBody = $this->controller->renderPartial('application.modules.user.views.email.accountActivatedEmail', array('model' => $user), true);

                Yii::app()->mail->send(Yii::app()->getModule('user')->notifyEmailFrom, $user->email, Yii::t('user', 'Аккаунт активирован!'), $emailBody);

                $this->controller->redirect(array(Yii::app()->getModule('user')->accountActivationSuccess));                
            }

            throw new CDbException(Yii::t('user', 'При активации аккаунта произошла ошибка!'));

        }
        catch (CDbException $e)
        {
            $transaction->rollback();

            Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE, Yii::t('user', 'При активации аккаунта произошла ошибка! Попробуйте позже!'));

            Yii::log(Yii::t('user', "При активации аккаунта c code => {code} произошла ошибка {error}!", array('{code}' => $code, '{error}' => $e->getMessage())), CLogger::LEVEL_ERROR, UserModule::$logCategory);

            $this->controller->redirect(array(Yii::app()->getModule('user')->accountActivationFailure));
        }
    }
}