<?php

/**
 *
 * @property integer $delivery_id
 * @property integer $payment_id
 *
 */
class DeliveryPayment extends \yupe\models\YModel
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{store_delivery_payment}}';
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
