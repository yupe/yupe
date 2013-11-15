<?php
/**
 * Created by JetBrains PhpStorm.
 * User: andrey
 * Date: 11/8/13
 * Time: 7:09 PM
 * To change this template use File | Settings | File Templates.
 */

class UserManager extends CApplicationComponent
{
    public $hasher;    
    
    public $tokenStorage;
    
    public function init()
    {          
        parent::init();
        
        $this->setHasher(Yii::createComponent($this->hasher));
        
        $this->setTokenStorage(Yii::createComponent($this->tokenStorage));
    }
    
    public function setTokenStorage(DbTokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }    
    
    public function setHasher(Hasher $hasher)
    {
        $this->hasher = $hasher;
    }
    
    public function createUser(RegistrationForm $form)
    {
        $transaction = Yii::app()->db->beginTransaction();
        
        try
        {
            $user = new User;            
            $data = $form->getAttributes();
            unset($data['cPassword'], $data['verifyCode']);
            $user->setAttributes($data);
            $user->hash = $this->hasher->hashPassword($form->password);
            
            if($user->save() && $this->tokenStorage->createAccountActivationToken($user)) {
                Yii::log(
                    Yii::t('UserModule.user', 'Account {nick_name} was created', array('{nick_name}' => $user->nick_name)),
                    CLogger::LEVEL_INFO, UserModule::$logCategory
                );
                
                $transaction->commit();
                return $user;
            }
            
            throw new CException(Yii::t('UserModule.user','Error creating account!'));
            
        }
        catch(Exception $e)
        {
            Yii::log(
                Yii::t('UserModule.user', 'Error {error} account creating!', array('{error}' => $e->__toString())),
                CLogger::LEVEL_INFO, UserModule::$logCategory
            );

            $transaction->rollback();

            return false;
        }
    }

    public function activateUser($token)
    {
        $transaction = Yii::app()->db->beginTransaction();

        try
        {
            $tokenModel = $this->tokenStorage->get($token, UserToken::TYPE_ACTIVATE);

            if(null === $tokenModel) {
                return false;
            }

            $userModel = User::model()->findByPk($tokenModel->user_id);

            if(null === $userModel) {
                return false;
            }

            $userModel->status  = User::STATUS_ACTIVE;
            $userModel->email_confirm = User::EMAIL_CONFIRM_YES;

            if($this->tokenStorage->activate($tokenModel) && $userModel->save()) {
                // Записываем информацию о событии в лог-файл:
                Yii::log(
                    Yii::t(
                        'UserModule.user', 'Account with activate_key = {activate_key} was activated!', array(
                            '{activate_key}' => $token
                        )
                    ),
                    CLogger::LEVEL_INFO, UserModule::$logCategory
                );

                $transaction->commit();

                return true;
            }

            throw new CException(Yii::t('UserModule.user', 'There was a problem with the activation of the account. Please refer to the site\'s administration.'));
        }
        catch(Exception $e)
        {

            $transaction->rollback();

            return false;
        }
    }

    public function passwordRecovery($email)
    {
        if(!$email) {
            return false;
        }

        $user = User::model()->active()->find('email = :email', array(
            ':email' => $email
        ));

        if(null === $user) {
            return false;
        }

        $transaction = Yii::app()->db->beginTransaction();

        try
        {
            if($this->tokenStorage->createPasswordRecoveryToken($user)) {

                $transaction->commit();

                return true;
            }

            throw new CException(Yii::t('UserModule.user', 'Password recovery error.'));
        }
        catch(Exception $e)
        {
            $transaction->rollback();

            return false;
        }
    }

    public function activatePassword($token, $password = null)
    {
        $tokenModel = $this->tokenStorage->get($token, UserToken::TYPE_CHANGE_PASSWORD);

        if(null === $tokenModel) {
            return false;
        }

        $userModel = User::model()->findByPk($tokenModel->user_id);

        if(null === $userModel) {
            return false;
        }

        $transaction = Yii::app()->db->beginTransaction();

        try
        {
            if(null === $password) {
                $password = $this->hasher->generateRandomPassword();
            }

            $userModel->hash = $this->hasher->hashPassword($password);

            if($userModel->save() && $this->tokenStorage->activate($tokenModel)) {

                $transaction->commit();

                return true;
            }

            throw new CException(Yii::t('UserModule.user','Error generating new password!'));
        }
        catch(Exception $e)
        {
            $transaction->rollback();

            return false;
        }
    }

    public function changeUserPassword(User $user, $password)
    {
        $user->hash = $this->hasher->hashPassword($password);
        return $user->save();
    }

    public function changeUserEmail(User $user, $email, $confirm = true)
    {
        $transaction = Yii::app()->db->beginTransaction();

        try
        {
            $user->email_confirm = User::EMAIL_CONFIRM_NO;
            $user->email = $email;
            if($user->save()) {
                if($confirm && !$this->tokenStorage->createEmailVerifyToken($user)) {
                    throw new CException(Yii::t('UserModule.user','Error change Email!'));
                }

                $transaction->commit();
                return true;
            }

            throw new CException(Yii::t('UserModule.user','Error change Email!'));
        }
        catch(Exception $e)
        {
            $transaction->rollback();
            return false;
        }
    }

    public function verifyEmail($token)
    {
        $transaction = Yii::app()->db->beginTransaction();

        try
        {
            $tokenModel = $this->tokenStorage->get($token, UserToken::TYPE_EMAIL_VERIFY);

            if(null === $tokenModel) {
                return false;
            }

            $userModel = User::model()->findByPk($tokenModel->user_id);

            if(null === $userModel) {
                return false;
            }

            $userModel->email_confirm = User::EMAIL_CONFIRM_YES;

            if($this->tokenStorage->activate($tokenModel) && $userModel->save()) {
                $transaction->commit();
                Yii::log(
                    Yii::t(
                        'UserModule.user', 'Email with activate_key = {activate_key}, id = {id} was activated!', array(
                            '{activate_key}' => $token,
                            '{id}'           => $userModel->id,
                        )
                    ),
                    CLogger::LEVEL_INFO, UserModule::$logCategory
                );
                return true;
            }

        }
        catch(Exception $e)
        {
            $transaction->rollback();
            return false;
        }
    }
}