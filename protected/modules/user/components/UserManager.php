<?php
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

    public function setTokenStorage(TokenStorage $tokenStorage)
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
            if($user->save() && ($token = $this->tokenStorage->createAccountActivationToken($user)) !== false) {

                Yii::log(
                    Yii::t('UserModule.user', 'Account {nick_name} was created', array('{nick_name}' => $user->nick_name)),
                    CLogger::LEVEL_INFO, UserModule::$logCategory
                );

                //@TODO
                Yii::app()->notify->send($user, Yii::t('UserModule.user', 'Registration on {site}',  array('{site}' => Yii::app()->getModule('yupe')->siteName)), '//user/email/needAccountActivationEmail', array(
                    'token' => $token
                ));

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
            if(($token = $this->tokenStorage->createPasswordRecoveryToken($user)) !== false) {

                //@TODO
                Yii::app()->notify->send($user, Yii::t('UserModule.user', 'Password recovery!'), '//user/email/passwordRecoveryEmail', array(
                    'token' => $token
                ));

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

    public function activatePassword($token, $password = null, $notify = true)
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

            if($this->changeUserPassword($userModel, $password) && $this->tokenStorage->activate($tokenModel)) {

                if(true === $notify) {
                    //@TODO
                    Yii::app()->notify->send($userModel,  Yii::t('UserModule.user','Your password was changed successfully!'), '//user/email/passwordRecoverySuccessEmail', array(
                        'password' => $password
                    ));
                }

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

                if($confirm && ($token = $this->tokenStorage->createEmailVerifyToken($user)) === false) {
                    throw new CException(Yii::t('UserModule.user','Error change Email!'));
                }

                //@TODO
                Yii::app()->notify->send($user, Yii::t('UserModule.user','Email verification'), '//user/email/needEmailActivationEmail', array(
                    'token' => $token
                ));

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