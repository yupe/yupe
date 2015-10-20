<?php
Yii::import('coupon.CouponModule'); // при вызове из корзины падает без этого
/**
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property double $value
 * @property double $min_order_price
 * @property integer $type
 * @property integer $registered_user
 * @property integer $free_shipping
 * @property string $start_time
 * @property string $end_time
 * @property integer $quantity
 * @property integer $quantity_per_user
 * @property integer $status
 *
 */
class Coupon extends yupe\models\YModel
{
    /**
     *
     */
    const STATUS_NOT_ACTIVE = 0;
    /**
     *
     */
    const STATUS_ACTIVE = 1;

    /**
     *
     */
    const TYPE_SUM = 0;
    /**
     *
     */
    const TYPE_PERCENT = 1;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{store_coupon}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['name, code, status, type', 'required'],
            ['name, code', 'filter', 'filter' => 'trim'],
            ['name, code', 'length', 'max' => 255],
            ['status', 'in', 'range' => array_keys($this->getStatusList())],
            ['type', 'in', 'range' => array_keys($this->getTypeList())],
            ['value, min_order_price', 'numerical'],
            ['quantity, quantity_per_user', 'numerical', 'integerOnly' => true],
            ['registered_user, free_shipping', 'in', 'range' => [0, 1]],
            ['start_time, end_time', 'date', 'format' => 'yyyy-MM-dd'],
            ['code', 'unique'],
            [
                'id, name, code, type, value, min_order_price, registered_user, free_shipping, start_time, end_time, quantity, quantity_per_user, status',
                'safe',
                'on' => 'search'
            ],
        ];
    }

    /**
     * @return array
     */
    public function scopes()
    {
        return [
            'active' => [
                'condition' => 'status = :status',
                'params' => [':status' => self::STATUS_ACTIVE],
            ],
        ];
    }

    /**
     * @return array
     */
    public function relations()
    {
        return [
            'ordersCount' => [self::STAT, 'OrderCoupon', 'coupon_id']
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('CouponModule.coupon', 'ID'),
            'name' => Yii::t('CouponModule.coupon', 'Title'),
            'code' => Yii::t('CouponModule.coupon', 'Code'),
            'value' => Yii::t('CouponModule.coupon', 'Discount value'),
            'min_order_price' => Yii::t('CouponModule.coupon', 'Min order price'),
            'type' => Yii::t('CouponModule.coupon', 'Type'),
            'registered_user' => Yii::t('CouponModule.coupon', 'Clients only'),
            'free_shipping' => Yii::t('CouponModule.coupon', 'Free delivery'),
            'start_time' => Yii::t('CouponModule.coupon', 'Start date'),
            'end_time' => Yii::t('CouponModule.coupon', 'End date'),
            'quantity' => Yii::t('CouponModule.coupon', 'Coupons amount'),
            'quantity_per_user' => Yii::t('CouponModule.coupon', 'Qty per user'),
            'status' => Yii::t('CouponModule.coupon', 'Status'),
        ];
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('value', $this->value);
        $criteria->compare('min_order_price', $this->min_order_price);
        $criteria->compare('type', $this->type);
        $criteria->compare('registered_user', $this->registered_user);
        $criteria->compare('free_shipping', $this->free_shipping);
        $criteria->compare('start_time', $this->start_time, true);
        $criteria->compare('end_time', $this->end_time, true);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('quantity_per_user', $this->quantity_per_user);
        $criteria->compare('status', $this->status);


        return new CActiveDataProvider(
            $this, [
                'criteria' => $criteria,
            ]
        );
    }


    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Coupon - the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     *
     */
    public function afterFind()
    {
        $this->start_time = !$this->start_time ? '' : date('Y-m-d', strtotime($this->start_time));
        $this->end_time = !$this->end_time ? '' : date('Y-m-d', strtotime($this->end_time));
        parent::afterFind();
    }

    /**
     * @return bool
     */
    public function beforeSave()
    {
        $this->start_time = $this->start_time ?: null;
        $this->end_time = $this->end_time ?: null;

        return parent::beforeSave();
    }

    /**
     * @return array
     */
    public function getStatusList()
    {
        return [
            self::STATUS_ACTIVE => Yii::t("CouponModule.coupon", 'Active'),
            self::STATUS_NOT_ACTIVE => Yii::t("CouponModule.coupon", 'Not active'),
        ];
    }

    /**
     * @return string
     */
    public function getStatusTitle()
    {
        $data = $this->getStatusList();

        return isset($data[$this->status]) ? $data[$this->status] : Yii::t("CouponModule.coupon", '*unknown*');
    }

    /**
     * @return array
     */
    public function getTypeList()
    {
        return [
            self::TYPE_SUM => Yii::t("CouponModule.coupon", 'Sum'),
            self::TYPE_PERCENT => Yii::t("CouponModule.coupon", 'Percent'),
        ];
    }

    /**
     * @return string
     */
    public function getTypeTitle()
    {
        $data = $this->getTypeList();

        return isset($data[$this->status]) ? $data[$this->status] : Yii::t("CouponModule.coupon", '*unknown*');
    }

    /**
     * @param $code
     * @return mixed
     */
    public function getCouponByCode($code)
    {
        return $this->active()->findByAttributes(['code' => $code]);
    }

    /**
     * @param int $price
     * @return array
     */
    public function getCouponErrors($price = 0)
    {
        $errors = [];

        if ($this->status == self::STATUS_NOT_ACTIVE) {
            $errors[] = Yii::t('CouponModule.coupon', 'Not active');
        }
        if ($price < $this->min_order_price) {
            $errors[] = Yii::t('CouponModule.coupon', 'Min order price') . Yii::t(
                    'CouponModule.coupon',
                    '{n} RUB|{n} RUB|{n} RUB',
                    [$this->min_order_price]
                );
        }
        if (!is_null($this->quantity) && $this->quantity <= 0) {
            $errors[] = Yii::t('CouponModule.coupon', 'Coupons are ended');
        }
        if (!is_null($this->quantity_per_user) && !Yii::app()->getUser()->getIsGuest() && ($this->getNumberUsagesByUser(Yii::app()->getUser()->getId()) >= $this->quantity_per_user)
        ) {
            $errors[] = Yii::t('CouponModule.coupon', 'You\'ve used up all your coupons');
        }
        if ($this->registered_user && Yii::app()->getUser()->getIsGuest()) {
            $errors[] = Yii::t('CouponModule.coupon', 'Coupon is available only for registered users');
        }
        if ($this->start_time && (time() < strtotime($this->start_time))) {
            $errors[] = Yii::t('CouponModule.coupon', 'Coupon start date not yet come');
        }
        if ($this->end_time && (time() > strtotime($this->end_time))) {
            $errors[] = Yii::t('CouponModule.coupon', 'Coupon expired');
        }

        return $errors;
    }

    /**
     * @param int $price
     * @return bool
     */
    public function getIsAvailable($price = 0)
    {
        return !$this->getCouponErrors($price);
    }

    /**
     * @param $price
     * @return float
     */
    public function getDiscount($price)
    {
        $discount = 0.00;

        if (!$this->getIsAvailable($price)) {
            return $discount;
        }

        switch ($this->type) {
            case self::TYPE_SUM:
                $discount += $this->value;
                break;
            case self::TYPE_PERCENT:
                $discount += ($this->value / 100) * $price;
                break;
        }

        return $discount;
    }

    /**
     *
     */
    public function decreaseQuantity()
    {
        if (!is_null($this->quantity)) {
            $this->quantity -= 1;
            $this->update(['quantity']);
        }
    }

    /**
     * @return string
     */
    public function getNumberUsagesByUser($userId)
    {
        return OrderCoupon::model()->with(['order'])->count(
            't.coupon_id = :id and order.user_id = :user_id',
            [
                ':id' => $this->id,
                'user_id' => (int)$userId
            ]
        );
    }
}
