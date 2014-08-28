<?php
use yupe\components\Event;

class UserLoginEvent extends Event
{
    protected $loginForm;

    protected $user;

    protected $identity;

    public function __construct(LoginForm $loginForm, IWebUser $user, UserIdentity $identity = null)
    {
        $this->identity = $identity;

        $this->loginForm = $loginForm;

        $this->user = $user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $loginForm
     */
    public function setLoginForm($loginForm)
    {
        $this->loginForm = $loginForm;
    }

    /**
     * @return mixed
     */
    public function getLoginForm()
    {
        return $this->loginForm;
    }

}
