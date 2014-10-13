<?php
namespace yupe\events;

use yupe\components\Event;

/**
 * Class YupeBeforeBackendControllerActionEvent
 * @package yupe\events
 */
class YupeControllerInitEvent extends Event
{
    /**
     * @var
     */
    protected $controller;

    /**
     * @var
     */
    protected $user;

    /**
     * @param \Controller $controller
     * @param \IWebUser $user
     */
    public function __construct(\CController $controller, \IWebUser $user)
    {
        $this->controller = $controller;
        $this->user = $user;
    }

    /**
     * @param mixed $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
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
