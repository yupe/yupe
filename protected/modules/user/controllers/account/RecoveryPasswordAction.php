<?php
class RecoveryPasswordAction extends CAction
{    
    //сброс пароля
    public function run()
    {
        $code = Yii::app()->request->getQuery('code');
        
        if(!$code)
        {
            Yii::log(Yii::t('user','Код восстановления ({code}) пароля не найден!',array('{code}' => $code)),CLogger::LEVEL_ERROR,UserModule::$logCategory);
            Yii::app()->user->setFlash(FlashMessagesWidget::ERROR_MESSAGE,Yii::t('user','Код восстановления пароля не найден! Попробуйте еще раз!'));
            $this->controller->redirect(array('/user/account/recovery'));
        }
        
        $recovery = RecoveryPassword::model()->with('user')->find('code = :code',array(':code' => $code));
        
        if(is_null($recovery) || is_null($recovery->user))
        {
            Yii::log(Yii::t('user','Код восстановления ({code}) пароля не найден!',array('{code}' => $code)),CLogger::LEVEL_ERROR,UserModule::$logCategory);
            Yii::app()->user->setFlash(FlashMessagesWidget::ERROR_MESSAGE,Yii::t('user','Код восстановления пароля не найден! Попробуйте еще раз!'));
            $this->controller->redirect(array('/user/account/recovery'));
        }       
        
        // автоматическое восстановление пароля
        if(Yii::app()->getModule('user')->autoRecoveryPassword)
        {
            
            $newPassword = Registration::model()->generateRandomPassword();            
            $recovery->user->password = Registration::model()->hashPassword($newPassword,$recovery->user->salt);            
            $transaction = Yii::app()->db->beginTransaction();
            try
            {                
                if($recovery->user->save() && RecoveryPassword::model()->deleteAll('userId = :userId',array(':userId' => $recovery->user->id)))
                {
                    $transaction->commit();
                    $emailBody = $this->controller->renderPartial('application.modules.user.views.email.passwordAutoRecoverySuccessEmail',array('model' => $recovery->user,'password' => $newPassword),true);                    
                    Yii::app()->mail->send(Yii::app()->getModule('user')->notifyEmailFrom,$recovery->user->email,Yii::t('user','Успешное восстановление пароля!'),$emailBody);                                                            
                    Yii::app()->user->setFlash(FlashMessagesWidget::NOTICE_MESSAGE,Yii::t('user','Новый пароль отправлен Вам на email!'));
                    Yii::log(Yii::t('user','Успешное восстановление пароля!'),CLogger::LEVEL_ERROR,UserModule::$logCategory);                
                    $this->controller->redirect(array('/user/account/login'));
                }
            }
            catch(CDbException $e)
            {
                $transaction->rollback();
                Yii::app()->user->setFlash(FlashMessagesWidget::ERROR_MESSAGE,Yii::t('user','Ошибка при смене пароля!'));
                Yii::log(Yii::t('user','Ошибка при автоматической смене пароля {error}!',array('{error}' => $e->getMessage())),CLogger::LEVEL_ERROR,UserModule::$logCategory);                
                $this->controller->redirect(array('/user/account/recovery'));   
            }
        }
        
        // выбор своего пароля
        
        $changePasswordForm = new ChangePasswordForm();
        
        // если отправили фому с новым паролем
        if(Yii::app()->request->isPostRequest && isset($_POST['ChangePasswordForm']))
        {
            $changePasswordForm->setAttributes($_POST['ChangePasswordForm']);
            
            if($changePasswordForm->validate())
            {
                $transaction = Yii::app()->db->beginTransaction();
                
                try
                {
                    // смена пароля пользователя                
                    $recovery->user->password  = Registration::model()->hashPassword($changePasswordForm->password,$recovery->user->salt);
                   
                    // удалить все запросы на восстановление для данного пользователя                       
                    if( $recovery->user->save() && RecoveryPassword::model()->deleteAll('userId = :userId',array(':userId' => $recovery->user->id)))
                    {
                        $transaction->commit();
                        Yii::app()->user->setFlash(FlashMessagesWidget::NOTICE_MESSAGE,Yii::t('user','Пароль изменен!'));
                        Yii::log(Yii::t('user','Успешная смена пароля для пользоателя {user}!',array('{user}' => $recovery->user->id)),CLogger::LEVEL_INFO,UserModule::$logCategory);
                        $emailBody = $this->controller->renderPartial('application.modules.user.views.email.passwordRecoverySuccessEmail',array('model' => $recovery->user),true);
                        Yii::app()->mail->send(Yii::app()->getModule('user')->notifyEmailFrom,$recovery->user->email,Yii::t('user','Успешное восстановление пароля!'),$emailBody);
                        $this->controller->redirect(array('/user/account/login'));
                    }
                }
                catch(CDbException $e)
                {
                    $transaction->rollback();
                    Yii::app()->user->setFlash(FlashMessagesWidget::ERROR_MESSAGE,Yii::t('user','Ошибка при смене пароля!'));
                    Yii::log(Yii::t('Ошибка при смене пароля {error}!',array('{error}' => $e->getMessage())),CLogger::LEVEL_ERROR,UserModule::$logCategory);
                    $this->controller->redirect(array('/user/account/recovery'));                    
                }
            }            
        }
        
        $this->controller->render('changePassword',array('model' => $changePasswordForm));
    }
}

?>
