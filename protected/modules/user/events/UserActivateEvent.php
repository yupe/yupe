<?php
use yupe\components\Event;

class UserActivateEvent extends Event
{
    protected $token;

    protected $user;

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
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
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    public function __construct($token,  User $user = null)
    {
        $this->token = $token;

        $this->user = $user;
    }
}
