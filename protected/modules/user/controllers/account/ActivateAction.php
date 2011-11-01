<?php
class ActivateAction extends CAction
{
    public function run($key)
    {       
        // пытаемся сделать выборку из таблицы пользователей
        $user = User::model()->notActivated()->find('activate_key = :activate_key', array(':activate_key' => $key));

        if (!$user)
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
        if (!Yii::app()->getModule('user')->isAllowedEmail($user->email))
        {
            // перенаправить на экшн для фиксации невалидных ip адресов
            $this->controller->redirect(array(Yii::app()->getModule('user')->invalidEmailAction));
        }


        if($user->activate())
        {
            Yii::log(Yii::t('user', "Активирован аккаунт с activate_key = {activate_key}!", array('{activate_key}' => $key)), CLogger::LEVEL_INFO, UserModule::$logCategory);

            Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('user', 'Вы успешно активировали аккаунт! Теперь Вы можете войти!'));

                // отправить сообщение о активации аккаунта
            $emailBody = $this->controller->renderPartial('accountActivatedEmail', array('model' => $user), true);

            Yii::app()->mail->send(Yii::app()->getModule('user')->notifyEmailFrom, $user->email, Yii::t('user', 'Аккаунт активирован!'), $emailBody);

            $this->controller->redirect(array(Yii::app()->getModule('user')->accountActivationSuccess));                
        }
        else
        {
            Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE, Yii::t('user', 'При активации аккаунта произошла ошибка! Попробуйте позже!'));

            Yii::log(Yii::t('user', "При активации аккаунта c activate_key => {activate_key} произошла ошибка {error}!", array('{activate_key}' => $key, '{error}' => $e->getMessage())), CLogger::LEVEL_ERROR, UserModule::$logCategory);

            $this->controller->redirect(array(Yii::app()->getModule('user')->accountActivationFailure));            
        }        
    }
}