<?php

use yupe\components\Event;

/**
 * Class PayOrderEvent
 */
class PayOrderEvent extends  Event
{
    /**
     * @var
     */
    protected $order;

    /**
     * @var
     */
    protected $payment;

    /**
     * @param Order $order
     * @param Payment $payment
     */
    public function __construct(Order $order, Payment $payment)
    {
        $this->order = $order;

        $this->payment = $payment;
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

    /**
     * @param mixed $payment
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;
    }

    /**
     * @return mixed
     */
    public function getPayment()
    {
        return $this->payment;
    }
} 
