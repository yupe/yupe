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
 * @property string $date_start
 * @property string $date_end
 * @property integer $quantity
 * @property integer $quantity_per_user
 * @property integer $status
 *
 */
class Coupon extends yupe\models\YModel
{
    const STATUS_NOT_ACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const TYPE_SUM = 0;
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
        return array(
            array('name, code, status, type', 'required'),
            array('name, code', 'filter', 'filter' => 'trim'),
            array('name, code', 'length', 'max' => 255),
            array('status', 'in', 'range' => array_keys($this->getStatusList())),
            array('type', 'in', 'range' => array_keys($this->getTypeList())),
            array('value, min_order_price', 'numerical'),
            array('quantity, quantity_per_user', 'numerical', 'integerOnly' => true),
            array('registered_user, free_shipping', 'in', 'range' => array(0, 1)),
            array('date_start, date_end', 'date', 'format' => 'yyyy-MM-dd'),
            array('code', 'unique'),
            array('id, name, code, type, value, min_order_price, registered_user, free_shipping, date_start, date_end, quantity, quantity_per_user, status', 'safe', 'on' => 'search'),
        );
    }

    public function scopes()
    {
        return array(
            'active' => array(
                'condition' => 'status = :status',
                'params' => array(':status' => self::STATUS_ACTIVE),
            ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('CouponModule.coupon', 'ID'),
            'name' => Yii::t('CouponModule.coupon', 'Название'),
            'code' => Yii::t('CouponModule.coupon', 'Код'),
            'value' => Yii::t('CouponModule.coupon', 'Величина скидки'),
            'min_order_price' => Yii::t('CouponModule.coupon', 'Минимальная сумма заказа'),
            'type' => Yii::t('CouponModule.coupon', 'Тип'),
            'registered_user' => Yii::t('CouponModule.coupon', 'Только для клиентов'),
            'free_shipping' => Yii::t('CouponModule.coupon', 'Бесплатная доставка'),
            'date_start' => Yii::t('CouponModule.coupon', 'Дата начала'),
            'date_end' => Yii::t('CouponModule.coupon', 'Дата конца'),
            'quantity' => Yii::t('CouponModule.coupon', 'Количество купонов'),
            'quantity_per_user' => Yii::t('CouponModule.coupon', 'Кол-во на одного пользователя'),
            'status' => Yii::t('CouponModule.coupon', 'Статус'),
        );
    }

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
        $criteria->compare('date_start', $this->date_start, true);
        $criteria->compare('date_end', $this->date_end, true);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('quantity_per_user', $this->quantity_per_user);
        $criteria->compare('status', $this->status);


        return new CActiveDataProvider(
            $this, array(
                'criteria' => $criteria,
            )
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

    public function afterFind()
    {
        $this->date_start = !$this->date_start ? '' : date('Y-m-d', strtotime($this->date_start));
        $this->date_end = !$this->date_end ? '' : date('Y-m-d', strtotime($this->date_end));
        parent::afterFind();
    }

    public function beforeSave()
    {
        $this->date_start = $this->date_start ?: null;
        $this->date_end = $this->date_end ?: null;
        return parent::beforeSave();
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_ACTIVE => Yii::t("CouponModule.coupon", 'Активен'),
            self::STATUS_NOT_ACTIVE => Yii::t("CouponModule.coupon", 'Неактивен'),
        );
    }

    public function getStatusTitle()
    {
        $data = $this->getStatusList();
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t("CouponModule.coupon", '*неизвестен*');
    }

    public function getTypeList()
    {
        return array(
            self::TYPE_SUM => Yii::t("CouponModule.coupon", 'Сумма'),
            self::TYPE_PERCENT => Yii::t("CouponModule.coupon", 'Процент'),
        );
    }

    public function getTypeTitle()
    {
        $data = $this->getTypeList();
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t("CouponModule.coupon", '*неизвестен*');
    }

    public function getCouponByCode($code)
    {
        return $this->findByAttributes(array('code' => $code));
    }

    public function getCouponErrors($price = 0)
    {
        $errors = array();
        if ($this->status == self::STATUS_NOT_ACTIVE) {
            $errors[] = Yii::t('CouponModule.coupon', 'Купон неактивен');
        }
        if ($price < $this->min_order_price) {
            $errors[] = Yii::t('CouponModule.coupon', 'Минимальная стоимость заказа ') . Yii::t('CouponModule.coupon', '{n} рубль|{n} рубля|{n} рублей', array($this->min_order_price));
        }
        if (!is_null($this->quantity) && $this->quantity <= 0) {
            $errors[] = Yii::t('CouponModule.coupon', 'Купоны закончились');
        }
        if (!is_null($this->quantity_per_user) && !Yii::app()->user->isGuest && ($this->getNumberUsagesByUser() >= $this->quantity_per_user)) {
            $errors[] = Yii::t('CouponModule.coupon', 'Вы использовали все свои купоны');
        }
        if ($this->registered_user && Yii::app()->user->isGuest) {
            $errors[] = Yii::t('CouponModule.coupon', 'Купон доступен только для зарегистрированных пользователей');
        }
        if ($this->date_start && (time() < strtotime($this->date_start))) {
            $errors[] = Yii::t('CouponModule.coupon', 'Время действия купона еще не началось');
        }
        if ($this->date_end && (time() > strtotime($this->date_end))) {
            $errors[] = Yii::t('CouponModule.coupon', 'Купон просрочен');
        }
        return $errors;
    }

    public function getIsAvailable($price = 0)
    {
        return !$this->getCouponErrors($price);
    }

    public function decreaseQuantity()
    {
        if (!is_null($this->quantity)) {
            $this->quantity -= 1;
            $this->save();
        }
    }

    public function getNumberUsagesByUser()
    {
        return Order::model()->count('coupon_code like :code and user_id = :user_id', array(':code' => '%' . $this->code . '%', 'user_id' => Yii::app()->user->id));
    }
}
