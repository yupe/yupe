<?php
use yupe\components\Event;

class UserEmailConfirmEvent extends Event
{
    protected $token;

    protected $user;

    public function __construct($token, User $user = null)
    {
        $this->token = $token;
        $this->user = $user;
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
}
