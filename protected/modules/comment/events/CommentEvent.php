<?php

use yupe\components\Event;

class CommentEvent extends Event
{
    protected $comment;

    protected $user;

    protected $module;

    public function __construct(Comment $comment, IWebUser $user, CommentModule $module)
    {
        $this->comment = $comment;

        $this->user = $user;

        $this->module = $module;
    }

    /**
     * @param \CommentModule $module
     */
    public function setModule($module)
    {
        $this->module = $module;
    }

    /**
     * @return \CommentModule
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
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
