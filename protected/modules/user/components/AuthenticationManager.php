<?php

/**
 * Class AuthenticationManager
 */
class AuthenticationManager extends CApplicationComponent
{
    /**
     * @var string
     */
    protected $badLoginCount = 'badLoginCount';

    /**
     * @param IWebUser $user
     * @return bool
     */
    public function logout(IWebUser $user)
    {
        Yii::app()->eventManager->fire(UserEvents::BEFORE_LOGOUT, new UserLogoutEvent(Yii::app()->getUser()));

        Yii::log(
            Yii::t('UserModule.user', 'User {user} was logout!', ['{user}' => $user->getState('nick_name')]),
            CLogger::LEVEL_INFO,
            UserModule::$logCategory
        );

        $user->logout();

        Yii::app()->eventManager->fire(UserEvents::AFTER_LOGOUT, new UserLogoutEvent());

        return true;
    }

    /**
     * @param LoginForm $form
     * @param IWebUser $user
     * @param CHttpRequest|null $request
     * @return bool
     */
    public function login(LoginForm $form, IWebUser $user, CHttpRequest $request = null)
    {
        if ($form->hasErrors()) {

            Yii::app()->eventManager->fire(UserEvents::FAILURE_LOGIN, new UserLoginEvent($form, $user));

            return false;
        }

        $identity = new UserIdentity($form->email, $form->password);

        $duration = 0;

        if ($form->remember_me) {
            $sessionTimeInWeeks = (int)Yii::app()->getModule('user')->sessionLifeTime;
            $duration = $sessionTimeInWeeks * 24 * 60 * 60;
        }

        if ($identity->authenticate()) {

            Yii::app()->eventManager->fire(UserEvents::BEFORE_LOGIN, new UserLoginEvent($form, $user, $identity));

            $user->login($identity, $duration);

            Yii::log(
                Yii::t(
                    'UserModule.user',
                    'User with {email} was logined with IP-address {ip}!',
                    [
                        '{email}' => $form->email,
                        '{ip}' => $request->getUserHostAddress(),
                    ]
                ),
                CLogger::LEVEL_INFO,
                UserModule::$logCategory
            );

            Yii::app()->eventManager->fire(UserEvents::SUCCESS_LOGIN, new UserLoginEvent($form, $user, $identity));

            return true;
        }

        Yii::app()->eventManager->fire(UserEvents::FAILURE_LOGIN, new UserLoginEvent($form, $user, $identity));

        Yii::log(
            Yii::t(
                'UserModule.user',
                'Authorization error with IP-address {ip}! email => {email}, Password => {password}!',
                [
                    '{email}' => $form->email,
                    '{password}' => $form->password,
                    '{ip}' => $request->getUserHostAddress(),
                ]
            ),
            CLogger::LEVEL_ERROR,
            UserModule::$logCategory
        );

        return false;
    }

    /**
     * @param IWebUser $user
     * @return int
     */
    public function getBadLoginCount(IWebUser $user)
    {
        return (int)$user->getState($this->badLoginCount, 0);
    }

    /**
     * @param IWebUser $user
     * @param $count
     */
    public function setBadLoginCount(IWebUser $user, $count)
    {
        $user->setState($this->badLoginCount, (int)$count);
    }
}
