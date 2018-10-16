<?php
use yupe\components\Event;

class CallbackAddEvent extends Event
{
    /**
     * @var \Callback
     */
    protected $model;

    public function __construct(\Callback $model)
    {
        $this->model = $model;
    }

    /**
     * @param \Callback $model
     */
    public function setModel(\Callback $model)
    {
        $this->model = $model;
    }

    /**
     * @return \Callback
     */
    public function getModel()
    {
        return $this->model;
    }
}
