<?php

/**
 * Class Client
 */
class Client extends User
{
    /**
     * @var
     */
    public $ordersTotalNumber;

    /**
     * @var
     */
    public $ordersTotalSum;

    /**
     * @param null|string $className
     * @return User|static
     */
    static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array|mixed
     */
    public function relations()
    {
        return CMap::mergeArray(
            parent::relations(),
            [
                'orders' => [self::HAS_MANY, 'Order', 'user_id'],
                'ordersCnt' => [self::STAT, 'Order', 'user_id'],
                'ordersSum' => [
                    self::STAT,
                    'Order',
                    'user_id',
                    'select' => 'SUM(total_price)',
                    'condition' => 'paid = :paid',
                    'params' => [
                        ':paid' => Order::PAID_STATUS_PAID,
                    ],
                ],
            ]
        );
    }

    /**
     * @return mixed
     */
    public function getOrderNumber()
    {
        return $this->ordersCnt;
    }

    /**
     * @return mixed
     */
    public function getOrderSum()
    {
        return $this->ordersSum;
    }


    /**
     * @return CActiveDataProvider
     */
    public function getOrders()
    {
        $provider = new CActiveDataProvider(
            'Order', [
                'criteria' => [
                    'condition' => 'user_id = :user',
                    'params' => [
                        ':user' => $this->id,
                    ],
                ],
            ]
        );

        return $provider;
    }

    /**
     * @return array|mixed
     */
    public function rules()
    {
        return CMap::mergeArray(
            parent::rules(),
            [
                [
                    'id, update_time, create_time, middle_name, first_name, last_name, nick_name, email, gender, avatar, status, access_level, visit_time, phone, ordersTotalNumber, ordersTotalSum',
                    'safe',
                    'on' => 'search',
                ],
            ]
        );
    }

    /**
     * Поиск пользователей по заданным параметрам:
     *
     * @return CActiveDataProvider
     */
    public function search($pageSize = 10)
    {
        $criteria = new CDbCriteria();

        $criteria->compare('t.first_name', $this->first_name, true, 'OR');
        $criteria->compare('t.middle_name', $this->middle_name, true, 'OR');
        $criteria->compare('t.last_name', $this->last_name, true, 'OR');
        $criteria->compare('t.nick_name', $this->nick_name, true, 'OR');
        $criteria->compare('t.email', $this->email, true, 'OR');
        $criteria->compare('t.phone', $this->phone, true, 'OR');
        $criteria->compare('t.gender', $this->gender);

        $orderTable = Order::model()->tableName();
        $orderNumberSql = "(select count(*) from {$orderTable} o where o.user_id = t.id) ";
        $orderSumSql = "(select sum(total_price) from {$orderTable} o where o.user_id = t.id AND o.paid = :paid) ";

        $criteria->compare($orderNumberSql, $this->ordersTotalNumber);
        $criteria->compare($orderSumSql, $this->ordersTotalSum);

        $criteria->select = [
            '*',
            $orderNumberSql.' as ordersTotalNumber',
            $orderSumSql.' as ordersTotalSum',
        ];

        $criteria->params[':paid'] = Order::PAID_STATUS_PAID;

        return new CActiveDataProvider(
            __CLASS__, [
                'criteria' => $criteria,
                'sort' => [
                    'defaultOrder' => 'visit_time DESC',
                    'attributes' => [
                        'ordersTotalNumber' => [
                            'asc' => 'ordersTotalNumber ASC',
                            'desc' => 'ordersTotalNumber DESC',
                        ],
                        'ordersTotalSum' => [
                            'asc' => 'ordersTotalSum ASC',
                            'desc' => 'ordersTotalSum DESC',
                        ],
                        '*',
                    ],
                ],
            ]
        );
    }
}