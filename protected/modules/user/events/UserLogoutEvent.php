<?php
use yupe\components\Event;

class UserLogoutEvent extends Event
{
    protected $user;

    public function __construct(IWebUser $user = null)
    {
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
}
