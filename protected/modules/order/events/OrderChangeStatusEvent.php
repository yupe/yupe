<?php

use yupe\components\Event;

/**
 * Class OrderChangeStatusEvent
 */
class OrderChangeStatusEvent extends Event
{
    /**
     * @var
     */
    protected  $order;

    /**
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @param mixed $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }
} 
