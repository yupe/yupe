<?php
use yupe\components\Event;

class UserPasswordRecoveryEvent extends Event
{
    protected $email;

    protected $user;

    public function __construct($email, User $user = null)
    {
        $this->email = $email;

        $this->user = $user;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
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