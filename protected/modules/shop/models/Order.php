<?php

/**
 * This is the model class for table "shop_order".
 *
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

    private $_orderProducts = array();
    private $hasProducts = false; // ставим в true, когда в сценарии front добавляем хотя бы один продукт

    protected $oldAttributes;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{shop_order}}';
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
        return array(
            array('status', 'required'),
            array('delivery_id, name, email', 'required', 'on' => self::SCENARIO_USER),
            array('name, email, address, phone', 'filter', 'filter' => 'trim'),
            array('email', 'email'),
            array('delivery_id, separate_delivery, payment_method_id, paid, user_id', 'numerical', 'integerOnly' => true),
            array('delivery_price, total_price, discount, coupon_discount', 'shop\components\validators\NumberValidator'),
            array('coupon_code, name, address, phone, email', 'length', 'max' => 255),
            array('comment, note', 'length', 'max' => 1024),
            //array('payment_details', 'safe'),
            array('url', 'unique'),
            array('user_id, paid, payment_date, payment_details, total_price, discount, coupon_discount, separate_delivery, status, date, ip, url, modified', 'unsafe', 'on' => self::SCENARIO_USER),
            array('status', 'in', 'range' => array_keys($this->getStatusList())),
            array('id, delivery_id, delivery_price, payment_method_id, paid, payment_date, payment_details, total_price, discount, coupon_discount, coupon_code, separate_delivery, status, date, user_id, name, address, phone, email, comment, ip, url, note, modified', 'safe', 'on' => 'search'),
        );
    }

    public function relations()
    {
        return array(
            'products' => array(self::HAS_MANY, 'OrderProduct', 'order_id', 'order' => 'products.id ASC'),
            'delivery' => array(self::BELONGS_TO, 'Delivery', 'delivery_id'),
            'payment' => array(self::BELONGS_TO, 'Payment', 'payment_method_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'setUpdateOnCreate' => true,
                'createAttribute' => 'date',
                'updateAttribute' => 'modified',
            ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('ShopModule.order', 'Номер'),
            'delivery_id' => Yii::t('ShopModule.order', 'Способ доставки'),
            'delivery_price' => Yii::t('ShopModule.order', 'Стоимость доставки'),
            'payment_method_id' => Yii::t('ShopModule.order', 'Способ оплаты'),
            'paid' => Yii::t('ShopModule.order', 'Оплачено'),
            'payment_date' => Yii::t('ShopModule.order', 'Дата оплаты'),
            'payment_details' => Yii::t('ShopModule.order', 'Детали платежа'),
            'total_price' => Yii::t('ShopModule.order', 'Полная стоимость'),
            'discount' => Yii::t('ShopModule.order', 'Скидка (%)'),
            'coupon_discount' => Yii::t('ShopModule.order', 'Скидка с купона'),
            'coupon_code' => Yii::t('ShopModule.order', 'Код купона'),
            'separate_delivery' => Yii::t('ShopModule.order', 'Доставка оплачивается отдельно'),
            'status' => Yii::t('ShopModule.order', 'Статус'),
            'date' => Yii::t('ShopModule.order', 'Дата'),
            'user_id' => Yii::t('ShopModule.order', 'Пользователь'),
            'name' => Yii::t('ShopModule.order', 'Имя'),
            'address' => Yii::t('ShopModule.order', 'Адрес'),
            'phone' => Yii::t('ShopModule.order', 'Телефон'),
            'email' => Yii::t('ShopModule.order', 'Email'),
            'comment' => Yii::t('ShopModule.order', 'Комментарий'),
            'ip' => Yii::t('ShopModule.order', 'IP'),
            'url' => Yii::t('ShopModule.order', 'Url'),
            'note' => Yii::t('ShopModule.order', 'Примечание'),
            'modified' => Yii::t('ShopModule.order', 'Дата изменения'),
        );
    }


    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

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


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array('defaultOrder' => $this->getTableAlias() . '.id DESC'),
        ));
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_NEW => 'Новый',
            self::STATUS_ACCEPTED => 'Принят',
            self::STATUS_FINISHED => 'Выполнен',
            self::STATUS_DELETED => 'Удален',
        );
    }

    public function getStatusTitle()
    {
        $data = $this->getStatusList();
        return isset($data[$this->status]) ? $data[$this->status] : '*неизвестен*';
    }

    public function afterFind()
    {
        $this->oldAttributes = $this->attributes;
        return parent::afterFind();
    }

    public function beforeValidate()
    {
        if ($this->getScenario() == self::SCENARIO_USER)
        {
            if ($this->total_price < $this->delivery->available_from)
            {
                $this->addError('delivery_id', Yii::t('ShopModule.order', 'Выбранный способ доставки недоступен'));
            }
            if (!$this->hasProducts)
            {
                $this->addError('products', Yii::t('ShopModule.order', 'Не выбрано ни одного продукта'));
            }
        }
        return parent::beforeValidate();
    }

    public function beforeSave()
    {
        if ($this->isNewRecord)
        {
            $this->url = md5(uniqid(time(), true));
            $this->ip  = Yii::app()->request->userHostAddress;
            if ($this->getScenario() == self::SCENARIO_USER)
            {
                $this->user_id           = Yii::app()->user->id;
                $this->delivery_price    = $this->delivery ? $this->delivery->getCost($this->total_price) : 0;
                $this->separate_delivery = $this->delivery ? $this->delivery->separate_payment : null;
            }
        }
        $this->total_price += $this->separate_delivery ? 0 : $this->delivery_price;
        if ($this->oldAttributes['paid'] == self::PAID_STATUS_NOT_PAID && $this->paid == self::PAID_STATUS_PAID)
        {
            $this->payment_date = new CDbExpression('now()');
        }
        else
        {
            $this->payment_date = null;
        }
        return parent::beforeSave();
    }

    public function afterDelete()
    {
        foreach ($this->products as $product)
        {
            $product->delete();
        }
        parent::afterDelete();
    }

    public function getPaidStatusList()
    {
        return array(
            self::PAID_STATUS_PAID => 'Оплачен',
            self::PAID_STATUS_NOT_PAID => 'Не оплачен',
        );
    }

    public function getPaidStatus()
    {
        $data = $this->getPaidStatusList();
        return isset($data[$this->paid]) ? $data[$this->paid] : '*неизвестен*';
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

        if (is_array($orderProducts))
        {
            $total_price = 0;
            foreach ($orderProducts as $key => $op)
            {
                /* для заказов с сайта необходимо пересчитать цену*/
                if ($this->getScenario() == self::SCENARIO_USER)
                {
                    $product = Product::model()->findByPk($op['product_id']);
                    if ($product)
                    {
                        $price                        = $product->getPrice($op['variant_ids']);
                        $orderProducts[$key]['price'] = $price;
                        $total_price += $price * (int)$op['quantity'];
                        $this->hasProducts = true;
                    }
                }
                else
                {
                    $total_price += (float)str_replace(',', '.', $op['price']) * (int)$op['quantity'];
                }
            }
            $this->_orderProducts = $orderProducts;
            $this->total_price    = $total_price;
        }
        else
        {
            $this->total_price = 0;
        }
    }

    /**
     * Формат массивы такой же как и у setOrderProducts()
     * @param $products
     */
    private function updateOrderProducts($products)
    {
        $orderProducts = array();
        foreach ($products as $var)
        {
            $orderProduct = null;
            if (isset($var['id']))
            {
                $orderProduct = OrderProduct::model()->findByPk($var['id']);
            }
            // для только что добавленных продуктов запишем имя продукта в заказ, на случай удаления его из базы
            if (!$orderProduct)
            {
                $orderProduct               = new OrderProduct();
                $pd                         = Product::model()->findByPk($var['product_id']);
                $orderProduct->product_name = $pd ? $pd->name : '*неизвестно*';
                $orderProduct->sku          = $pd ? $pd->sku : '*неизвестно*';
            }
            $orderProduct->attributes = $var;
            $orderProduct->order_id   = $this->id;

            if ($orderProduct->save())
            {
                $orderProducts[] = $orderProduct->id;
            }
        }

        $criteria = new CDbCriteria();
        $criteria->addCondition('order_id = :order_id');
        $criteria->params = array(':order_id' => $this->id);
        $criteria->addNotInCondition('id', $orderProducts);
        OrderProduct::model()->deleteAll($criteria);
    }

    public function afterSave()
    {
        $this->updateOrderProducts($this->_orderProducts);
        parent::afterSave();
    }

    /**
     * Вызывается после успешной оплаты заказа, например, тут можно уменьшить количество товаров на складе
     */
    public function close()
    {
        return true;
    }
}
