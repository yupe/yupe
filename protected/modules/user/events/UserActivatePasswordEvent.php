<?php
use yupe\components\Event;

/**
 * Class UserActivatePasswordEvent
 */
class UserActivatePasswordEvent extends Event
{
    /**
     * @var bool
     */
    protected $notify;

    /**
     * @var
     */
    protected $token;

    /**
     * @var
     */
    protected $password;

    /**
     * @var
     */
    protected $user;

    /**
     * @param $token
     * @param $password
     * @param $user
     */
    public function __construct($token, $password = null, User $user = null, $notify = true)
    {
        $this->token = $token;
        $this->password = $password;
        $this->user = $user;
        $this->notify = $notify;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param boolean $notify
     */
    public function setNotify($notify)
    {
        $this->notify = $notify;
    }

    /**
     * @return boolean
     */
    public function getNotify()
    {
        return $this->notify;
    }

    /**
     * @param \User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return \User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }
}
