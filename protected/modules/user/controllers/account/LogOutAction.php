<?php
class LogOutAction extends CAction
{
    public function run()
    {
        Yii::log(
            Yii::t('UserModule.user', 'Пользователь {user} вышел!', array('{user}' => Yii::app()->user->getState('nick_name'))),
            CLogger::LEVEL_INFO, UserModule::$logCategory
        );

        Yii::app()->user->logout();

        $this->controller->redirect(array(Yii::app()->getModule('user')->logoutSuccess));
    }
}