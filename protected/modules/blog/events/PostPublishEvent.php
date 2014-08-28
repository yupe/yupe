<?php

use yupe\components\Event;

class PostPublishEvent extends Event
{
    protected $post;

    protected $user;

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
