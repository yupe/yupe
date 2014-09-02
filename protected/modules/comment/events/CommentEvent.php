<?php

use yupe\components\Event;

/**
 * Class CommentEvent
 */
class CommentEvent extends Event
{
    /**
     * @var Comment
     */
    protected $comment;

    /**
     * @var IWebUser
     */
    protected $user;

    /**
     * @var CommentModule
     */
    protected $module;

    /**
     * @var CHttpRequest
     */
    protected $request;

    /**
     * @param Comment $comment
     * @param IWebUser $user
     * @param CommentModule $module
     * @param CHttpRequest $request
     */
    public function __construct(Comment $comment, IWebUser $user, CommentModule $module, CHttpRequest $request = null)
    {
        $this->comment = $comment;

        $this->user = $user;

        $this->module = $module;

        $this->request = $request;
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
     * @param \CHttpRequest $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    /**
     * @return \CHttpRequest
     */
    public function getRequest()
    {
        return $this->request;
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
