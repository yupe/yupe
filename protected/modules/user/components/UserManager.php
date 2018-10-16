<?php

/**
 * Class UserManager
 */
class UserManager extends CApplicationComponent
{
    /**
     * @var Hasher
     */
    public $hasher;

    /**
     * @var TokenStorage
     */
    public $tokenStorage;

    /**
     * @var UserModule
     */
    public $userModule;

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->setHasher(Yii::createComponent($this->hasher));

        $this->setTokenStorage(Yii::createComponent($this->tokenStorage));

        $this->userModule = Yii::app()->getModule('user');
    }

    /**
     * @param TokenStorage $tokenStorage
     */
    public function setTokenStorage(TokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param Hasher $hasher
     */
    public function setHasher(Hasher $hasher)
    {
        $this->hasher = $hasher;
    }

    /**
     * @param RegistrationForm $form
     * @return bool|User
     */
    public function createUser(RegistrationForm $form)
    {
        $transaction = Yii::app()->getDb()->beginTransaction();

        try {

            $user = new User;

            $user->setAttributes([
                'nick_name' => $form->nick_name,
                'email' => $form->email,
            ]);

            if (!$this->userModule->emailAccountVerification) {
                $user->setAttributes([
                    'status' => User::STATUS_ACTIVE,
                    'email_confirm' => User::EMAIL_CONFIRM_YES,
                ]);
            }

            $user->setAttribute('hash', $this->hasher->hashPassword($form->password));

            if ($user->save() && ($token = $this->tokenStorage->createAccountActivationToken($user)) !== false) {

                if (!$this->userModule->emailAccountVerification) {
                    Yii::app()->eventManager->fire(
                        UserEvents::SUCCESS_REGISTRATION,
                        new UserRegistrationEvent($form, $user, $token)
                    );
                } else {
                    Yii::app()->eventManager->fire(
                        UserEvents::SUCCESS_REGISTRATION_NEED_ACTIVATION,
                        new UserRegistrationEvent($form, $user, $token)
                    );
                }

                $transaction->commit();

                return $user;
            }

            throw new CException(Yii::t('UserModule.user', 'Error creating account!'));

        } catch (Exception $e) {

            Yii::log(
                Yii::t('UserModule.user', 'Error {error} account creating!', ['{error}' => $e->__toString()]),
                CLogger::LEVEL_INFO,
                UserModule::$logCategory
            );

            $transaction->rollback();

            Yii::app()->eventManager->fire(UserEvents::FAILURE_REGISTRATION, new UserRegistrationEvent($form, $user));

            return false;
        }
    }

    /**
     * @param $token
     * @return bool
     */
    public function activateUser($token)
    {
        $transaction = Yii::app()->getDb()->beginTransaction();

        try {
            $tokenModel = $this->tokenStorage->get($token, UserToken::TYPE_ACTIVATE);

            if (null === $tokenModel) {

                Yii::app()->eventManager->fire(UserEvents::FAILURE_ACTIVATE_ACCOUNT, new UserActivateEvent($token));

                return false;
            }

            $userModel = User::model()->findByPk($tokenModel->user_id);

            if (null === $userModel) {

                Yii::app()->eventManager->fire(UserEvents::FAILURE_ACTIVATE_ACCOUNT, new UserActivateEvent($token));

                return false;
            }

            $userModel->activate();

            if ($this->tokenStorage->activate($tokenModel) && $userModel->save()) {

                Yii::app()->eventManager->fire(
                    UserEvents::SUCCESS_ACTIVATE_ACCOUNT,
                    new UserActivateEvent($token, $userModel)
                );

                $transaction->commit();

                return true;
            }

            throw new CException(
                Yii::t(
                    'UserModule.user',
                    'There was a problem with the activation of the account. Please refer to the site\'s administration.'
                )
            );
        } catch (Exception $e) {
            $transaction->rollback();

            Yii::app()->eventManager->fire(UserEvents::FAILURE_ACTIVATE_ACCOUNT, new UserActivateEvent($token));

            return false;
        }
    }

    /**
     * @param $email
     * @return bool
     */
    public function passwordRecovery($email)
    {
        Yii::app()->eventManager->fire(UserEvents::BEFORE_PASSWORD_RECOVERY, new UserPasswordRecoveryEvent($email));

        if (!$email) {
            return false;
        }

        $user = User::model()->active()->find(
            'email = :email',
            [
                ':email' => $email,
            ]
        );

        if (null === $user) {
            return false;
        }

        $transaction = Yii::app()->getDb()->beginTransaction();

        try {
            if (($token = $this->tokenStorage->createPasswordRecoveryToken($user)) !== false) {

                Yii::app()->eventManager->fire(
                    UserEvents::SUCCESS_PASSWORD_RECOVERY,
                    new UserPasswordRecoveryEvent($email, $user, $token)
                );

                $transaction->commit();

                return true;
            }

            throw new CException(Yii::t('UserModule.user', 'Password recovery error.'));
        } catch (Exception $e) {

            $transaction->rollback();

            Yii::app()->eventManager->fire(
                UserEvents::FAILURE_PASSWORD_RECOVERY,
                new UserPasswordRecoveryEvent($email, $user)
            );

            return false;
        }
    }

    /**
     * @param $token
     * @param null $password
     * @param bool|true $notify
     * @return bool
     */
    public function activatePassword($token, $password = null, $notify = true)
    {
        $tokenModel = $this->tokenStorage->get($token, UserToken::TYPE_CHANGE_PASSWORD);

        if (null === $tokenModel) {

            Yii::app()->eventManager->fire(
                UserEvents::FAILURE_ACTIVATE_PASSWORD,
                new UserActivatePasswordEvent($token)
            );

            return false;
        }

        $userModel = User::model()->active()->findByPk($tokenModel->user_id);

        if (null === $userModel) {

            Yii::app()->eventManager->fire(
                UserEvents::FAILURE_ACTIVATE_PASSWORD,
                new UserActivatePasswordEvent($token)
            );

            return false;
        }

        $transaction = Yii::app()->getDb()->beginTransaction();

        try {

            if (null === $password) {
                $password = $this->hasher->generateRandomPassword();
            }

            if ($this->changeUserPassword($userModel, $password) && $this->tokenStorage->activate($tokenModel)) {

                Yii::app()->eventManager->fire(
                    UserEvents::SUCCESS_ACTIVATE_PASSWORD,
                    new UserActivatePasswordEvent($token, $password, $userModel, $notify)
                );

                $transaction->commit();

                return true;
            }

            throw new CException(Yii::t('UserModule.user', 'Error generating new password!'));
        } catch (Exception $e) {
            $transaction->rollback();

            return false;
        }
    }

    /**
     * @param User $user
     * @param $password
     * @return bool
     */
    public function changeUserPassword(User $user, $password)
    {
        $user->hash = $this->hasher->hashPassword($password);

        return $user->save();
    }

    /**
     * @param User $user
     * @param $email
     * @param bool|true $confirm
     * @return bool
     */
    public function changeUserEmail(User $user, $email, $confirm = true)
    {
        if ($user->email == $email) {
            return true;
        }

        $transaction = Yii::app()->getDb()->beginTransaction();

        try {

            $user->email_confirm = User::EMAIL_CONFIRM_NO;
            $user->email = $email;
            if ($user->save()) {

                if ($confirm && ($token = $this->tokenStorage->createEmailVerifyToken($user)) === false) {
                    throw new CException(Yii::t('UserModule.user', 'Error change Email!'));
                }

                Yii::app()->eventManager->fire(
                    UserEvents::SUCCESS_EMAIL_CHANGE,
                    new UserEmailConfirmEvent($token, $user)
                );

                $transaction->commit();

                return true;
            }

            throw new CException(Yii::t('UserModule.user', 'Error change Email!'));
        } catch (Exception $e) {
            $transaction->rollback();

            return false;
        }
    }

    /**
     * @param $token
     * @return bool
     */
    public function verifyEmail($token)
    {
        $transaction = Yii::app()->getDb()->beginTransaction();

        try {
            $tokenModel = $this->tokenStorage->get($token, UserToken::TYPE_EMAIL_VERIFY);

            if (null === $tokenModel) {

                Yii::app()->eventManager->fire(UserEvents::FAILURE_EMAIL_CONFIRM, new UserEmailConfirmEvent($token));

                return false;
            }

            $userModel = User::model()->active()->findByPk($tokenModel->user_id);

            if (null === $userModel) {

                Yii::app()->eventManager->fire(UserEvents::FAILURE_EMAIL_CONFIRM, new UserEmailConfirmEvent($token));

                return false;
            }

            $userModel->email_confirm = User::EMAIL_CONFIRM_YES;

            if ($this->tokenStorage->activate($tokenModel) && $userModel->save()) {

                Yii::app()->eventManager->fire(
                    UserEvents::SUCCESS_EMAIL_CONFIRM,
                    new UserEmailConfirmEvent($token, $userModel)
                );

                $transaction->commit();

                return true;
            }

        } catch (Exception $e) {
            $transaction->rollback();

            Yii::app()->eventManager->fire(UserEvents::FAILURE_EMAIL_CONFIRM, new UserEmailConfirmEvent($token));
        }

        return false;
    }

    /**
     * @param $email
     * @param int $status
     * @return User
     */
    public function isUserExist($email, $status = User::STATUS_ACTIVE)
    {
        $criteria = new CDbCriteria();
        $criteria->addColumnCondition(['email' => $email]);
        $criteria->addColumnCondition(['status' => $status]);

        return User::model()->find($criteria);
    }

    /**
     * @param $email
     * @param null $status
     * @return User
     */
    public function findUserByEmail($email, $status = null)
    {
        $criteria = new CDbCriteria();
        $criteria->addColumnCondition(['email' => $email]);

        if (null !== $status) {
            $criteria->addColumnCondition(['status' => $status]);
        }

        return User::model()->find($criteria);
    }
}
