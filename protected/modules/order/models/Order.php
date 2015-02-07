<?php

/**
 * @property integer $id
 * @property integer  $delivery_id
 * @property double  $delivery_price
 * @property integer  $payment_method_id
 * @property integer  $paid
 * @property string  $payment_date
 * @property string $payment_details
 * @property double $total_price
 * @property double $discount
 * @property double $coupon_discount
 * @property string $coupon_code
 * @property integer $separate_delivery
 * @property integer $status
 * @property string $date
 * @property integer $user_id
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property string $email
 * @property string $comment
 * @property string $ip
 * @property string $url
 * @property string $note
 * @property string $modified
 *
 * @property OrderProduct[] $products
 * @property Delivery $delivery
 * @property Payment $payment
 * @property User $user
 *
 */
Yii::import('application.modules.order.OrderModule');
Yii::import('application.modules.order.events.OrderEvents');
Yii::import('application.modules.order.events.PayOrderEvent');
Yii::import('application.modules.order.events.OrderChangeStatusEvent');

class Order extends yupe\models\YModel
{
    const STATUS_NEW = 0;
    const STATUS_ACCEPTED = 1;
    const STATUS_FINISHED = 2;
    const STATUS_DELETED = 3;

    const PAID_STATUS_NOT_PAID = 0;
    const PAID_STATUS_PAID = 1;

    const SCENARIO_USER = 'front';
    const SCENARIO_ADMIN = 'admin';

    /**
     * @var OrderProduct[]
     */
    private $_orderProducts = [];

    private $hasProducts = false; // ставим в true, когда в сценарии front добавляем хотя бы один продукт

    protected $oldAttributes;

    protected $couponCodes = [];

    private $productsChanged = false; // менялся ли список продуктов в заказе


    private $_validCoupons = null;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{store_order}}';
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['status, delivery_id', 'required'],
            ['name, email', 'required', 'on' => self::SCENARIO_USER],
            ['name, email, address, phone', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['delivery_id, separate_delivery, payment_method_id, paid, user_id', 'numerical', 'integerOnly' => true],
            ['delivery_price, total_price, discount, coupon_discount', 'store\components\validators\NumberValidator'],
            ['name, address, phone, email', 'length', 'max' => 255],
            ['comment, note', 'length', 'max' => 1024],
            //array('payment_details', 'safe'),
            ['url', 'unique'],
            [
                'user_id, paid, payment_date, payment_details, total_price, discount, coupon_discount, separate_delivery, status, date, ip, url, modified',
                'unsafe',
                'on' => self::SCENARIO_USER
            ],
            ['couponCodes', 'safe'], // сюда отправляется массив купонок, которые потом разбираются в beforeSave()
            ['status', 'in', 'range' => array_keys($this->getStatusList())],
            [
                'id, delivery_id, delivery_price, payment_method_id, paid, payment_date, payment_details, total_price, discount, coupon_discount, coupon_code, separate_delivery, status, date, user_id, name, address, phone, email, comment, ip, url, note, modified',
                'safe',
                'on' => 'search'
            ],
        ];
    }

    public function relations()
    {
        return [
            'products' => [self::HAS_MANY, 'OrderProduct', 'order_id', 'order' => 'products.id ASC'],
            'delivery' => [self::BELONGS_TO, 'Delivery', 'delivery_id'],
            'payment' => [self::BELONGS_TO, 'Payment', 'payment_method_id'],
            'user' => [self::BELONGS_TO, 'User', 'user_id'],
        ];
    }

    public function scopes()
    {
        return [
            'new' => [
                'condition' => 't.status = :status',
                'params' => [':status' => self::STATUS_NEW],
            ],
        ];
    }

    public function behaviors()
    {
        return [
            'CTimestampBehavior' => [
                'class' => 'zii.behaviors.CTimestampBehavior',
                'setUpdateOnCreate' => true,
                'createAttribute' => 'date',
                'updateAttribute' => 'modified',
            ],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('OrderModule.order', 'Номер'),
            'delivery_id' => Yii::t('OrderModule.order', 'Способ доставки'),
            'delivery_price' => Yii::t('OrderModule.order', 'Стоимость доставки'),
            'payment_method_id' => Yii::t('OrderModule.order', 'Способ оплаты'),
            'paid' => Yii::t('OrderModule.order', 'Оплачено'),
            'payment_date' => Yii::t('OrderModule.order', 'Дата оплаты'),
            'payment_details' => Yii::t('OrderModule.order', 'Детали платежа'),
            'total_price' => Yii::t('OrderModule.order', 'Полная стоимость'),
            'discount' => Yii::t('OrderModule.order', 'Скидка (%)'),
            'coupon_discount' => Yii::t('OrderModule.order', 'Скидка с купона'),
            'coupon_code' => Yii::t('OrderModule.order', 'Код купона'),
            'separate_delivery' => Yii::t('OrderModule.order', 'Доставка оплачивается отдельно'),
            'status' => Yii::t('OrderModule.order', 'Статус'),
            'date' => Yii::t('OrderModule.order', 'Дата'),
            'user_id' => Yii::t('OrderModule.order', 'Пользователь'),
            'name' => Yii::t('OrderModule.order', 'Клиент'),
            'address' => Yii::t('OrderModule.order', 'Адрес'),
            'phone' => Yii::t('OrderModule.order', 'Телефон'),
            'email' => Yii::t('OrderModule.order', 'Email'),
            'comment' => Yii::t('OrderModule.order', 'Комментарий'),
            'ip' => Yii::t('OrderModule.order', 'IP'),
            'url' => Yii::t('OrderModule.order', 'Url'),
            'note' => Yii::t('OrderModule.order', 'Примечание'),
            'modified' => Yii::t('OrderModule.order', 'Дата изменения'),
        ];
    }


    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('delivery_id', $this->delivery_id, false);
        $criteria->compare('delivery_price', $this->delivery_price, false);
        $criteria->compare('payment_method_id', $this->payment_method_id, false);
        $criteria->compare('paid', $this->paid, false);
        $criteria->compare('payment_date', $this->payment_date, true);
        $criteria->compare('payment_details', $this->payment_details, true);
        $criteria->compare('total_price', $this->total_price, false);
        $criteria->compare('discount', $this->discount, false);
        $criteria->compare('coupon_discount', $this->coupon_discount, false);
        $criteria->compare('coupon_code', $this->coupon_code, true);
        $criteria->compare('separate_delivery', $this->separate_delivery, false);
        $criteria->compare('status', $this->status, false);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('user_id', $this->user_id, false);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('comment', $this->comment, true);
        $criteria->compare('ip', $this->ip, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('modified', $this->modified, true);


        return new CActiveDataProvider(
            $this, [
                'criteria' => $criteria,
                'sort' => ['defaultOrder' => $this->getTableAlias() . '.id DESC'],
            ]
        );
    }

    public function getStatusList()
    {
        return [
            self::STATUS_NEW => Yii::t("OrderModule.order", 'Новый'),
            self::STATUS_ACCEPTED => Yii::t("OrderModule.order", 'Принят'),
            self::STATUS_FINISHED => Yii::t("OrderModule.order", 'Выполнен'),
            self::STATUS_DELETED => Yii::t("OrderModule.order", 'Удален'),
        ];
    }

    public function getStatusTitle()
    {
        $data = $this->getStatusList();

        return isset($data[$this->status]) ? $data[$this->status] : Yii::t("OrderModule.order", '*неизвестен*');
    }

    public function afterFind()
    {
        $this->oldAttributes = $this->getAttributes();
        $this->couponCodes = preg_split('/,/', $this->coupon_code);
        parent::afterFind();
    }

    public function beforeValidate()
    {
        if ($this->getScenario() == self::SCENARIO_USER) {

            if (!$this->hasProducts) {
                $this->addError('products', Yii::t('OrderModule.order', 'Не выбрано ни одного продукта'));
            }
        }

        return parent::beforeValidate();
    }

    public function getProductsCost()
    {
        $cost = 0;
        $products = $this->productsChanged ? $this->_orderProducts : $this->products;

        foreach ($products as $op) {
            $cost += $op->price * $op->quantity;
        }

        return $cost;
    }

    public function isCouponsAvailable()
    {
        return Yii::app()->hasModule('coupon');
    }

    public function hasCoupon()
    {
        return !empty($this->coupon_code);
    }

    public function getCouponsCodes()
    {
        return $this->couponCodes;
    }

    public function setCouponsCodes(array $coupons)
    {
        $this->couponCodes = $coupons;
    }

    public function getDeliveryCost()
    {
        $cost = $this->delivery_price;
        if ($this->isCouponsAvailable()) {
            $validCoupons = $this->getValidCoupons($this->getCouponsCodes());
            foreach ($validCoupons as $coupon) {
                if ($coupon->free_shipping) {
                    $cost = 0;
                }
            }
        }

        return $cost;
    }


    /**
     * Фильтрует переданные коды купонов и возвращает объекты купонов
     * @param $codes - массив кодов купонов
     * @return Coupon[] - массив объектов-купонов
     */
    public function getValidCoupons($codes)
    {
        if ($this->_validCoupons !== null) {
            return $this->_validCoupons;
        }

        $productsTotalPrice = $this->getProductsCost();

        $validCoupons = [];

        /* @var $coupon Coupon */
        /* проверим купоны на валидность */
        foreach ($codes as $code) {

            $coupon = Coupon::model()->getCouponByCode($code);

            if (null !== $coupon && $coupon->getIsAvailable($productsTotalPrice)) {
                $validCoupons[] = $coupon;
            }
        }

        return $validCoupons;
    }

    /**
     * Получает скидку для переданных купонов
     * @param $coupons Coupon[]
     * @return float - скидка
     */
    public function getCouponDiscount($coupons)
    {
        $productsTotalPrice = $this->getProductsCost();
        $delta = 0.00; // суммарная скидка по купонам
        /* посчитаем скидку */
        if ($this->isCouponsAvailable()) {
            foreach ($coupons as $coupon) {
                switch ($coupon->type) {
                    case Coupon::TYPE_SUM:
                        $delta += $coupon->value;
                        break;
                    case Coupon::TYPE_PERCENT:
                        $delta += ($coupon->value / 100) * $productsTotalPrice;
                        break;
                }
            }
        }

        return $delta;
    }

    public function beforeSave()
    {
        $productsCost = $this->getProductsCost();

        if ($this->getIsNewRecord()) {
            $this->url = md5(uniqid(time(), true));
            $this->ip = Yii::app()->getRequest()->userHostAddress;
            if ($this->getScenario() == self::SCENARIO_USER) {
                $this->user_id = Yii::app()->getUser()->getId();
                $this->delivery_price = $this->delivery ? $this->delivery->getCost($productsCost) : 0;
                $this->separate_delivery = $this->delivery ? $this->delivery->separate_payment : null;
            }
        }

        $validCouponCodes = [];
        $coupons = [];

        if ($this->isCouponsAvailable()) {
            /* количество купонов уменьшаем только при создании записи*/
            $coupons = $this->getValidCoupons($this->getCouponsCodes());
            foreach ($coupons as $coupon) {
                $validCouponCodes[] = $coupon->code;
                if ($this->getIsNewRecord()) {
                    $coupon->decreaseQuantity();
                }
            }
        }

        $this->coupon_code = join(',', $validCouponCodes);

        $this->coupon_discount = $this->getCouponDiscount($coupons);

        $this->delivery_price = $this->getDeliveryCost();

        /* итоговая цена получается из стоимости доставки (если доставка не оплачивается отдельно) + стоимость всех продуктов - скидка по купонам */
        $this->total_price = ($this->separate_delivery ? 0 : $this->delivery_price) + $productsCost - $this->coupon_discount;

        return parent::beforeSave();
    }

    public function afterDelete()
    {
        foreach ($this->products as $product) {
            $product->delete();
        }
        parent::afterDelete();
    }

    public function getPaidStatusList()
    {
        return [
            self::PAID_STATUS_PAID => Yii::t("OrderModule.order", 'Оплачен'),
            self::PAID_STATUS_NOT_PAID => Yii::t("OrderModule.order", 'Не оплачен'),
        ];
    }

    public function getPaidStatus()
    {
        $data = $this->getPaidStatusList();

        return isset($data[$this->paid]) ? $data[$this->paid] : Yii::t("OrderModule.order", '*неизвестен*');
    }


    /**
     *
     * Формат массива:
     * <pre>
     * array(
     *    '45' => array( //реальный id или сгенерированный новый, у новых внутри массива нет id
     *        'id' => '10', //если нет id, то новый
     *        'variant_ids' => array('10', '20, '30'), // массив с id вариантов
     *        'quantity' = > '5',
     *        'price' => '1000',
     *        'product_id' => '123',
     *    )
     * )
     * </pre>
     * @param $orderProducts Array
     */
    public function setOrderProducts($orderProducts)
    {
        $this->productsChanged = true;
        $orderProductsObjectsArray = [];
        if (is_array($orderProducts)) {
            foreach ($orderProducts as $key => $op) {
                $product = null;
                if (isset($op['product_id'])) {
                    $product = Product::model()->findByPk($op['product_id']);
                }
                $variantIds = isset($op['variant_ids']) ? $op['variant_ids'] : [];
                if ($product) {
                    $this->hasProducts = true;
                }

                /* @var $orderProduct OrderProduct */
                $orderProduct = null;
                if (isset($op['id'])) {
                    $orderProduct = OrderProduct::model()->findByPk($op['id']);
                }

                if (!$orderProduct) {
                    $orderProduct = new OrderProduct();
                    $orderProduct->product_id = $product->id;
                    $orderProduct->product_name = $product->name;
                    $orderProduct->sku = $product->sku;
                }

                if ($this->getScenario() == self::SCENARIO_USER) {
                    $orderProduct->price = $product->getPrice($variantIds);
                } else {
                    $orderProduct->price = $op['price'];
                }

                $orderProduct->variant_ids = $variantIds;
                $orderProduct->quantity = $op['quantity'];

                $orderProductsObjectsArray[] = $orderProduct;
            }
            $this->_orderProducts = $orderProductsObjectsArray;
        }
    }

    /**
     * Массив объектов OrderProduct
     * @param $products
     */
    private function updateOrderProducts($products)
    {
        if (!$this->productsChanged) {
            return;
        }

        $validOrderProductIds = [];

        foreach ($products as $var) {
            /* @var $var OrderProduct */
            if ($var->getIsNewRecord()) {
                $var->order_id = $this->id;
            }

            if ($var->save()) {
                $validOrderProductIds[] = $var->id;
            }
        }

        $criteria = new CDbCriteria();
        $criteria->addCondition('order_id = :order_id');
        $criteria->params = [':order_id' => $this->id];
        $criteria->addNotInCondition('id', $validOrderProductIds);
        OrderProduct::model()->deleteAll($criteria);
    }

    public function afterSave()
    {
        $this->updateOrderProducts($this->_orderProducts);
        parent::afterSave();
    }


    public function getTotalPrice()
    {
        return (float)$this->total_price - (!$this->separate_delivery ? 0 : $this->getDeliveryPrice());
    }

    public function getDeliveryPrice()
    {
        return (float)$this->delivery_price;
    }

    public function getTotalPriceWithDelivery()
    {
        return $this->getTotalPrice() + $this->getDeliveryPrice();
    }

    public function isPaid()
    {
        return $this->paid === static::PAID_STATUS_PAID;
    }

    public function pay(Payment $payment)
    {
        if ($this->isPaid()) {
            return true;
        }

        $this->paid = static::PAID_STATUS_PAID;
        $this->payment_method_id = $payment->id;
        $this->payment_date = new CDbExpression('now()');

        $result = $this->save();

        if ($result) {
            Yii::app()->eventManager->fire(OrderEvents::SUCCESS_PAID, new PayOrderEvent($this, $payment));
        } else {
            Yii::app()->eventManager->fire(OrderEvents::FAILURE_PAID, new PayOrderEvent($this, $payment));
        }

        return $result;
    }

    public function findByUrl($url)
    {
        return $this->findByAttributes(['url' => $url]);
    }

    public function isStatusChanged()
    {
        if ($this->oldAttributes['status'] != $this->status) {

            Yii::app()->eventManager->fire(OrderEvents::STATUS_CHANGED, new OrderChangeStatusEvent($this));

            return true;
        }

        return false;
    }

    public function findByNumber($number)
    {
        return $this->findByPk($number);
    }
}
