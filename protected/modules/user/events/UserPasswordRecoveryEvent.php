<?php
use yupe\components\Event;

class UserPasswordRecoveryEvent extends Event
{
    /**
     * @var
     */
    protected $email;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var UserToken
     */
    protected $token;

    /**
     * @param $email
     * @param User $user
     * @param UserToken $token
     */
    public function __construct($email, User $user = null, UserToken $token = null)
    {
        $this->email = $email;

        $this->user = $user;

        $this->token = $token;
    }

    /**
     * @param \UserToken $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return \UserToken
     */
    public function getToken()
    {
        return $this->token;
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
