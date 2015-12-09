<?php

class Client extends User
{
    public function relations()
    {
        return CMap::mergeArray(
            parent::relations(),
            [
                'orders' => [self::HAS_MANY, 'Order', 'user_id'],
                'ordersCnt' => [self::STAT, 'Order', 'user_id'],
                'ordersSum' => [self::STAT, 'Order', 'user_id', 'select' => 'SUM(total_price)', 'condition' => 'paid = :paid', 'params' => [
                    ':paid' => Order::PAID_STATUS_PAID
                ]]
            ]
        );
    }

    public function getOrderNumber()
    {
        return $this->ordersCnt;
    }

    public function getOrderSum()
    {
        return $this->ordersSum;
    }
}