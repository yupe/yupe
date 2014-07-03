<?php
use yupe\components\Event;

/**
 * Class UserActivatePasswordEvent
 */
class UserActivatePasswordEvent extends Event
{
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
    function __construct($token, $password = null, User $user)
    {
        $this->token = $token;
        $this->password = $password;
        $this->user = $user;
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