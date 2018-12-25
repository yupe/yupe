<?php
/**
 * @property integer $id
 * @property integer $delivery_id
 * @property double $delivery_price
 * @property integer $payment_method_id
 * @property integer $paid
 * @property string $payment_time
 * @property string $payment_details
 * @property double $total_price
 * @property double $discount
 * @property double $coupon_discount
 * @property integer $separate_delivery
 * @property integer $status_id
 * @property string $date
 * @property integer $user_id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $comment
 * @property string $ip
 * @property string $url
 * @property string $note
 * @property string $modified
 * @property string $zipcode
 * @property string $country
 * @property string $city
 * @property string $street
 * @property string $house
 * @property string $apartment
 * @property integer $manager_id
 *
 * @property OrderProduct[] $products
 * @property Delivery $delivery
 * @property Payment $payment
 * @property User $user
 * @property OrderStatus $status
 *
 */
use yupe\widgets\YPurifier;

Yii::import('application.modules.order.OrderModule');
Yii::import('application.modules.order.events.OrderEvents');
Yii::import('application.modules.order.events.PayOrderEvent');
Yii::import('application.modules.order.events.OrderEvent');
Yii::import('application.modules.order.events.OrderChangeStatusEvent');

/**
 * Class Order
 */
class Order extends yupe\models\YModel
{
    /**
     *
     */
    const PAID_STATUS_NOT_PAID = 0;
    /**
     *
     */
    const PAID_STATUS_PAID = 1;

    /**
     *
     */
    const SCENARIO_USER = 'front';
    /**
     *
     */
    const SCENARIO_ADMIN = 'admin';

    /**
     * @var null
     */
    public $couponId = null;

    /**
     * @var OrderProduct[]
     */
    private $_orderProducts = [];

    /**
     * @var bool
     */
    private $hasProducts = false; // ставим в true, когда в сценарии front добавляем хотя бы один продукт

    /**
     * @var
     */
    protected $oldAttributes;

    /**
     * @var bool
     */
    private $productsChanged = false; // менялся ли список продуктов в заказе

    /**
     * @var null
     */
    private $_validCoupons = null;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{store_order}}';
    }

    /**
     * @param null|string $className
     * @return $this
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['name, email, phone, zipcode, country, city, street, house, apartment', 'filter', 'filter' => 'trim'],
            ['name, email, phone, zipcode, country, city, street, house, apartment, comment', 'filter', 'filter' => [$obj = new YPurifier(), 'purify']],
            ['status_id, delivery_id', 'required'],
            ['name, email', 'required', 'on' => self::SCENARIO_USER],
            ['email', 'email'],
            [
                'delivery_id, separate_delivery, payment_method_id, paid, user_id, couponId, manager_id',
                'numerical',
                'integerOnly' => true,
            ],
            ['delivery_price, total_price, discount, coupon_discount', 'store\components\validators\NumberValidator'],
            ['name, phone, email, city, street', 'length', 'max' => 255],
            ['comment, note', 'length', 'max' => 1024],
            ['zipcode', 'length', 'max' => 30],
            ['house', 'length', 'max' => 50],
            ['country', 'length', 'max' => 150],
            ['apartment', 'length', 'max' => 10],
            ['url', 'unique'],
            [
                'user_id, paid, payment_time, payment_details, total_price, discount, coupon_discount, separate_delivery, status_id, date, ip, url, modified',
                'unsafe',
                'on' => self::SCENARIO_USER,
            ],
            [
                'id, delivery_id, delivery_price, payment_method_id, paid, payment_time, payment_details, total_price, discount, coupon_discount, separate_delivery, status_id, date, user_id, name, phone, email, comment, ip, url, note, modified, manager_id',
                'safe',
                'on' => 'search',
            ],
        ];
    }

    /**
     * @return array
     */
    public function relations()
    {
        return [
            'products' => [self::HAS_MANY, 'OrderProduct', 'order_id', 'order' => 'products.id ASC'],
            'delivery' => [self::BELONGS_TO, 'Delivery', 'delivery_id'],
            'payment' => [self::BELONGS_TO, 'Payment', 'payment_method_id'],
            'status' => [self::BELONGS_TO, 'OrderStatus', 'status_id'],
            'client' => [self::BELONGS_TO, 'Client', 'user_id'],
            'manager' => [self::BELONGS_TO, 'User', 'manager_id'],
            'couponsIds' => [self::HAS_MANY, 'OrderCoupon', 'order_id'],
            'coupons' => [self::HAS_MANY, 'Coupon', 'coupon_id', 'through' => 'couponsIds'],
        ];
    }

    /**
     * @return array
     */
    public function scopes()
    {
        return [
            'new' => [
                'condition' => 't.status_id = :status_id',
                'params' => [':status_id' => OrderStatus::STATUS_NEW],
            ],
        ];
    }

    /**
     * @return array
     */
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
            'id' => Yii::t('OrderModule.order', '#'),
            'delivery_id' => Yii::t('OrderModule.order', 'Delivery method'),
            'delivery_price' => Yii::t('OrderModule.order', 'Delivery price'),
            'payment_method_id' => Yii::t('OrderModule.order', 'Payment method'),
            'paid' => Yii::t('OrderModule.order', 'Paid'),
            'payment_time' => Yii::t('OrderModule.order', 'Paid date'),
            'payment_details' => Yii::t('OrderModule.order', 'Payment details'),
            'total_price' => Yii::t('OrderModule.order', 'Total price'),
            'discount' => Yii::t('OrderModule.order', 'Discount (%)'),
            'coupon_discount' => Yii::t('OrderModule.order', 'Discount coupon'),
            'separate_delivery' => Yii::t('OrderModule.order', 'Separate delivery payment'),
            'status_id' => Yii::t('OrderModule.order', 'Status'),
            'date' => Yii::t('OrderModule.order', 'Created'),
            'user_id' => Yii::t('OrderModule.order', 'Client'),
            'name' => Yii::t('OrderModule.order', 'Client'),
            'phone' => Yii::t('OrderModule.order', 'Phone'),
            'email' => Yii::t('OrderModule.order', 'Email'),
            'comment' => Yii::t('OrderModule.order', 'Comment'),
            'ip' => Yii::t('OrderModule.order', 'IP'),
            'url' => Yii::t('OrderModule.order', 'Url'),
            'note' => Yii::t('OrderModule.order', 'Note'),
            'modified' => Yii::t('OrderModule.order', 'Update date'),
            'zipcode' => Yii::t('OrderModule.order', 'Zipcode'),
            'country' => Yii::t('OrderModule.order', 'Country'),
            'city' => Yii::t('OrderModule.order', 'City'),
            'street' => Yii::t('OrderModule.order', 'Street'),
            'house' => Yii::t('OrderModule.order', 'House'),
            'apartment' => Yii::t('OrderModule.order', 'Apartment'),
            'manager_id' => Yii::t('OrderModule.order', 'Manager'),
        ];
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->with = ['delivery', 'payment', 'client', 'status'];

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('delivery_id', $this->delivery_id);
        $criteria->compare('delivery_price', $this->delivery_price);
        $criteria->compare('payment_method_id', $this->payment_method_id);
        $criteria->compare('paid', $this->paid);
        $criteria->compare('payment_time', $this->payment_time);
        $criteria->compare('payment_details', $this->payment_details, true);
        $criteria->compare('total_price', $this->total_price);
        $criteria->compare('total_price', $this->total_price);
        $criteria->compare('discount', $this->discount);
        $criteria->compare('coupon_discount', $this->coupon_discount);
        $criteria->compare('separate_delivery', $this->separate_delivery);
        $criteria->compare('t.status_id', $this->status_id);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('comment', $this->comment, true);
        $criteria->compare('ip', $this->ip, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('modified', $this->modified, true);
        $criteria->compare('t.manager_id', $this->manager_id);

        if (null !== $this->couponId) {
            $criteria->with['couponsIds'] = ['together' => true];
            $criteria->addCondition('couponsIds.coupon_id = :id');
            $criteria->params = CMap::mergeArray($criteria->params, [':id' => $this->couponId]);
        }

        if (null !== $this->name) {
            $clientCriteria = new CDbCriteria();
            $clientCriteria->with['client'] = ['together' => true];
            $clientCriteria->addSearchCondition('client.last_name', $this->name, true, 'OR');
            $clientCriteria->addSearchCondition('client.first_name', $this->name, true, 'OR');
            $clientCriteria->addSearchCondition('client.middle_name', $this->name, true, 'OR');
            $clientCriteria->addSearchCondition('client.nick_name', $this->name, true, 'OR');
            $criteria->mergeWith($clientCriteria, 'OR');
        }

        return new CActiveDataProvider(
            __CLASS__, [
                'criteria' => $criteria,
                'sort' => ['defaultOrder' => $this->getTableAlias().'.id DESC'],
            ]
        );
    }

    /**
     * @return CActiveDataProvider
     */
    public function searchCoupons()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('t.order_id', $this->id);

        $criteria->with = ['coupon'];

        return new CActiveDataProvider(
            OrderCoupon::_CLASS_(), [
                'criteria' => $criteria,
            ]
        );
    }

    /**
     *
     */
    public function afterFind()
    {
        $this->oldAttributes = $this->getAttributes();
        parent::afterFind();
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        if ($this->getScenario() === self::SCENARIO_USER) {

            if (!$this->hasProducts) {
                $this->addError('products', Yii::t('OrderModule.order', 'There are no selected products'));
            }
        }

        return parent::beforeValidate();
    }

    /**
     * @return float|int
     */
    public function getProductsCost()
    {
        $cost = 0;
        $products = $this->productsChanged ? $this->_orderProducts : $this->products;

        foreach ($products as $op) {
            $cost += $op->price * $op->quantity;
        }

        return $cost;
    }

    /**
     * @return bool
     */
    public function isCouponsAvailable()
    {
        return Yii::app()->hasModule('coupon');
    }

    /**
     * @return bool
     */
    public function hasCoupons()
    {
        return !empty($this->couponsIds);
    }

    /**
     * @return array
     */
    public function getCouponsCodes()
    {
        $codes = [];

        foreach ($this->coupons as $coupon) {
            $codes[] = $coupon->code;
        }

        return $codes;
    }

    /**
     * @return mixed
     */
    public function getCoupons()
    {
        return $this->coupons;
    }

    /**
     * @return int|mixed
     */
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
    public function getCouponDiscount(array $coupons)
    {
        $productsTotalPrice = $this->getProductsCost();
        $delta = 0.00;
        if ($this->isCouponsAvailable()) {
            foreach ($coupons as $coupon) {
                switch ($coupon->type) {
                    case CouponType::TYPE_SUM:
                        $delta += $coupon->value;
                        break;
                    case CouponType::TYPE_PERCENT:
                        $delta += ($coupon->value / 100) * $productsTotalPrice;
                        break;
                }
            }
        }

        return $delta;
    }

    /**
     * @param array $attributes
     * @param array $products
     * @param int $status
     * @param int $client
     *
     * @return bool
     */
    public function store(array $attributes, array $products, $client = null, $status = OrderStatus::STATUS_NEW)
    {
        $isNew = $this->getIsNewRecord();
        $transaction = Yii::app()->getDb()->beginTransaction();

        try {

            $this->status_id = (int)$status;
            $this->user_id = $client;
            $this->setAttributes($attributes);
            $this->setProducts($products);

            if (!$this->save()) {
                return false;
            }

            Yii::app()->eventManager->fire(
                $isNew ? OrderEvents::CREATED : OrderEvents::UPDATED,
                new OrderEvent($this)
            );

            $transaction->commit();

            return true;
        } catch (Exception $e) {
            $transaction->rollback();

            return false;
        }
    }

    /**
     * @param array $coupons
     * @return bool
     */
    public function applyCoupons(array $coupons)
    {
        if (!$this->isCouponsAvailable()) {
            return true;
        }

        $coupons = $this->getValidCoupons($coupons);

        $transaction = Yii::app()->getDb()->beginTransaction();

        try {

            foreach ($coupons as $coupon) {

                $model = new OrderCoupon();

                $model->setAttributes(
                    [
                        'order_id' => $this->id,
                        'coupon_id' => $coupon->id,
                        'create_time' => new CDbExpression('NOW()'),
                    ]
                );

                $model->save();

                $coupon->decreaseQuantity();
            }

            $this->coupon_discount = $this->getCouponDiscount($coupons);

            $this->delivery_price = $this->getDeliveryCost();

            $this->update(['coupon_discount', 'delivery_price']);

            $transaction->commit();

            return true;
        } catch (Exception $e) {
            $transaction->rollback();

            return false;
        }
    }

    /**
     * @return bool
     * @TODO вынести всю логику в saveData
     */
    public function beforeSave()
    {
        $this->total_price = $this->getProductsCost();

        if ($this->getIsNewRecord()) {
            $this->url = md5(uniqid(time(), true));
            $this->ip = Yii::app()->getRequest()->userHostAddress;
            if ($this->getScenario() === self::SCENARIO_USER) {
                $this->delivery_price = $this->delivery ? $this->delivery->getCost($this->total_price) : 0;
                $this->separate_delivery = $this->delivery ? $this->delivery->separate_payment : null;
            }
        }

        $this->delivery_price = $this->getDeliveryCost();

        // Контроль остатков товара на складе
        // @TODO реализовать перерасчет остатков товаров при изменении списка заказанных товаров администратором
        if ($this->getIsNewRecord() && Yii::app()->getModule('store')->controlStockBalances) {
            foreach ($this->_orderProducts as $orderProduct) {
                $product = $orderProduct->product;
                if ($orderProduct->quantity > $product->getAvailableQuantity()) {
                    $this->addError(
                        'products',
                        Yii::t(
                            "OrderModule.order",
                            'Not enough product «{product_name}» in stock, maximum - {n} items', [
                                '{product_name}' => $product->getName(),
                                '{n}' => $product->getAvailableQuantity(),
                            ]
                        )
                    );
                    return false;
                }

                // Изменение значения количества товара
                $newQuantity = $product->quantity - $orderProduct->quantity;
                $product->saveAttributes(['quantity' => $newQuantity]);
            }
        }

        return parent::beforeSave();
    }

    /**
     *
     */
    public function afterDelete()
    {
        foreach ($this->products as $product) {
            $product->delete();
        }
        parent::afterDelete();
    }

    /**
     * @return array
     */
    public function getPaidStatusList()
    {
        return [
            self::PAID_STATUS_PAID => Yii::t("OrderModule.order", 'Paid'),
            self::PAID_STATUS_NOT_PAID => Yii::t("OrderModule.order", 'Not paid'),
        ];
    }

    /**
     * @return string
     */
    public function getPaidStatus()
    {
        $data = $this->getPaidStatusList();

        return isset($data[$this->paid]) ? $data[$this->paid] : Yii::t("OrderModule.order", '*unknown*');
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
    public function setProducts($orderProducts)
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

                $orderProduct->variantIds = $variantIds;
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

    /**
     *
     */
    public function afterSave()
    {
        $this->updateOrderProducts($this->_orderProducts);
        parent::afterSave();
    }

    /**
     * @return float
     */
    public function getTotalPrice()
    {
        return (float)$this->total_price - (float)$this->discount - (float)$this->coupon_discount;
    }

    /**
     * @return float
     */
    public function getDeliveryPrice()
    {
        return (float)$this->delivery_price;
    }

    /**
     * @return float
     */
    public function getTotalPriceWithDelivery()
    {
        $price = $this->getTotalPrice();

        if (!$this->separate_delivery) {
            $price += $this->getDeliveryPrice();
        }

        return $price;
    }

    /**
     * @return bool
     */
    public function isPaid()
    {
        return (int)$this->paid === static::PAID_STATUS_PAID;
    }

    /**
     * @return mixed
     */
    public function isPaymentMethodSelected()
    {
        return $this->payment_method_id;
    }


    /**
     * @param Payment $payment
     * @param int $paid
     * @return bool
     */
    public function pay(Payment $payment, $paid = self::PAID_STATUS_PAID)
    {
        if ($this->isPaid()) {
            return true;
        }

        $this->setAttributes([
            'paid' => (int)$paid,
            'payment_method_id' => $payment->id,
            'payment_time' => new CDbExpression('NOW()'),
        ]);

        $result = $this->save();

        if ($result) {
            Yii::app()->eventManager->fire(OrderEvents::SUCCESS_PAID, new PayOrderEvent($this, $payment));
        } else {
            Yii::app()->eventManager->fire(OrderEvents::FAILURE_PAID, new PayOrderEvent($this, $payment));
        }

        return $result;
    }

    /**
     * @param $url
     * @return static
     */
    public function findByUrl($url)
    {
        return $this->findByAttributes(['url' => $url]);
    }

    /**
     * @return bool
     * @TODO реализовать перерасчет остатков товаров при отмене заказа
     */
    public function isStatusChanged()
    {
        if ($this->oldAttributes['status_id'] != $this->status_id) {

            Yii::app()->eventManager->fire(OrderEvents::STATUS_CHANGED, new OrderChangeStatusEvent($this));

            return true;
        }

        return false;
    }

    /**
     * @param $number
     * @return static
     */
    public function findByNumber($number)
    {
        return $this->findByPk($number);
    }

    /**
     * @param string $separator
     * @return string
     */
    public function getAddress($separator = ', ')
    {
        return implode($separator, [
            $this->zipcode,
            $this->country,
            $this->city,
            $this->street,
            $this->house,
            $this->apartment,
        ]);
    }

    /**
     * @return CActiveDataProvider
     */
    public function getProducts()
    {
        return new CActiveDataProvider(
            'OrderProduct', [
                'criteria' => [
                    'condition' => 'order_id = :id',
                    'params' => [
                        ':id' => $this->id,
                    ],
                ],
            ]
        );
    }

    /**
     * @return string
     */
    public function getStatusTitle()
    {
        return isset($this->status) ? $this->status->name : Yii::t('OrderModule.order', '*unknown*');
    }

    /**
     * @param IWebUser $user
     * @return bool
     */
    public function checkManager(IWebUser $user)
    {
        if (!$this->manager_id) {
            return true;
        }

        if (((int)$this->manager_id === (int)$user->getId()) || $user->isSuperUser()) {
            return true;
        }

        return false;
    }
}
