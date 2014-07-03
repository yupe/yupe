<?php
use yupe\components\Event;

class UserActivateEvent extends Event
{
    protected $token;

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

    public function __construct($token)
    {
        $this->token = $token;
    }
} 