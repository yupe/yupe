<?php
use yupe\components\Event;

class BlogJoinLeaveEvent extends Event
{
    protected $blog;

    protected $userId;

    public function __construct(Blog $blog, $userId)
    {
        $this->blog = $blog;
        $this->userId = $userId;
    }

    /**
     * @param mixed $user
     */
    public function setUserId($user)
    {
        $this->userId = $user;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $blog
     */
    public function setBlog($blog)
    {
        $this->blog = $blog;
    }

    /**
     * @return mixed
     */
    public function getBlog()
    {
        return $this->blog;
    }
}
