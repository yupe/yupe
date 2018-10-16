<?php

use yupe\components\Event;

/**
 * Class OrderEvent
 */
class OrderEvent extends Event
{
    /**
     * @var
     */
    protected $order;

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * OrderEvent constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}