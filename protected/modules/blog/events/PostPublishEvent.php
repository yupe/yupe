<?php

use yupe\components\Event;

/**
 * Class PostPublishEvent
 */
class PostPublishEvent extends Event
{
    /**
     * @var Post
     */
    protected $post;

    /**
     * @var IWebUser
     */
    protected $user;

    /**
     * PostPublishEvent constructor.
     * @param Post $post
     * @param IWebUser $user
     */
    public function __construct(Post $post, IWebUser $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * @param mixed $post
     */
    public function setPost($post)
    {
        $this->post = $post;
    }

    /**
     * @return mixed
     */
    public function getPost()
    {
        return $this->post;
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
