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
        if (false === $form->validate()) {

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

            if ($user->login($identity, $duration)) {

                Yii::app()->eventManager->fire(UserEvents::SUCCESS_LOGIN, new UserLoginEvent($form, $user, $identity));

                return true;
            }
        }

        Yii::app()->eventManager->fire(UserEvents::FAILURE_LOGIN, new UserLoginEvent($form, $user, $identity));

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
