<?php
class AuthenticationManager extends CApplicationComponent
{
    protected $badLoginCount  = 'badLoginCount';

    public function logout(IWebUser $user)
    {
        Yii::log(
            Yii::t('UserModule.user', 'User {user} was logout!', array('{user}' => $user->getState('nick_name'))),
            CLogger::LEVEL_INFO, UserModule::$logCategory
        );

        return $user->logout();
    }

    public function login(LoginForm $form, IWebUser $user, CHttpRequest $request = null)
    {
        if ($form->hasErrors()) {
           return false;
        }

        $identity = new UserIdentity($form->email, $form->password);

        $duration = 0;

        if ($form->remember_me) {
            $sessionTimeInWeeks = (int)Yii::app()->getModule('user')->sessionLifeTime;
            $duration = $sessionTimeInWeeks*24*60*60;
        }

        if ($identity->authenticate()) {
            $user->login($identity, $duration);
            Yii::log(
                Yii::t(
                    'UserModule.user', 'User with {email} was logined with IP-address {ip}!', array(
                        '{email}' => $form->email,
                        '{ip}'    => $request->getUserHostAddress(),
                    )
                ),
                CLogger::LEVEL_INFO, UserModule::$logCategory
            );
            return true;
        }

        Yii::log(
            Yii::t(
                'UserModule.user', 'Authorization error with IP-address {ip}! email => {email}, Password => {password}!', array(
                    '{email}'    => $form->email,
                    '{password}' => $form->password,
                    '{ip}'       => $request->getUserHostAddress(),
                )
            ),
            CLogger::LEVEL_ERROR, UserModule::$logCategory
        );

        return false;
    }

    public function getBadLoginCount(IWebUser $user)
    {
        return (int)$user->getState($this->badLoginCount, 0);
    }

    public function setBadLoginCount(IWebUser $user, $count)
    {
        $user->setState($this->badLoginCount, (int)$count);
    }
} 