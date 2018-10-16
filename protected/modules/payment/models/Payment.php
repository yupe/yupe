<?php

/**
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $settings
 * @property integer $position
 * @property integer $status
 * @property integer $currency_id
 * @property string $module
 */
class Payment extends yupe\models\YModel
{
    /**
     *
     */
    const STATUS_ACTIVE = 1;
    /**
     *
     */
    const STATUS_NOT_ACTIVE = 0;

    /**
     * @var array
     */
    private $_paymentSettings = [];

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{store_payment}}';
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
            ['name, position, status', 'required'],
            ['name', 'filter', 'filter' => 'trim'],
            ['currency_id', 'numerical', 'integerOnly' => true],
            ['name', 'length', 'max' => 255],
            ['module', 'length', 'max' => 100],
            ['description', 'safe'],
            ['status', 'in', 'range' => array_keys($this->getStatusList())],
            ['id, module, name, description, settings, currency_id, position, status', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array
     */
    public function scopes()
    {
        return [
            'published' => [
                'condition' => 'status = :status',
                'params' => [':status' => self::STATUS_ACTIVE],
            ],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('PaymentModule.payment', 'ID'),
            'name' => Yii::t('PaymentModule.payment', 'Title'),
            'description' => Yii::t('PaymentModule.payment', 'Description'),
            'status' => Yii::t('PaymentModule.payment', 'Status'),
            'position' => Yii::t('PaymentModule.payment', 'Position'),
            'module' => Yii::t('PaymentModule.payment', 'Payment system'),
            'currency_id' => Yii::t('PaymentModule.payment', 'Currency'),
            'settings' => Yii::t('PaymentModule.payment', 'Payment system settings'),
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
        $criteria->compare('module', $this->module, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('position', $this->position);
        $criteria->compare('currency_id', $this->currency_id);
        $criteria->compare('description', $this->description, true);

        return new CActiveDataProvider(
            $this, [
                'criteria' => $criteria,
                'sort' => ['defaultOrder' => 't.position'],
            ]
        );
    }

    /**
     * @return array
     */
    public function getStatusList()
    {
        return [
            self::STATUS_ACTIVE => Yii::t("PaymentModule.payment", 'Active'),
            self::STATUS_NOT_ACTIVE => Yii::t("PaymentModule.payment", 'Not active'),
        ];
    }

    /**
     * @return mixed|string
     */
    public function getStatusTitle()
    {
        $data = $this->getStatusList();

        return isset($data[$this->status]) ? $data[$this->status] : Yii::t("PaymentModule.payment", '*unknown*');
    }

    /**
     * @return bool
     */
    public function beforeSave()
    {
        $this->settings = serialize($this->_paymentSettings);

        return parent::beforeSave();
    }

    /**
     *
     */
    public function afterFind()
    {
        $this->_paymentSettings = unserialize($this->settings);

        parent::afterFind();
    }

    /**
     *
     */
    public function afterDelete()
    {
        $this->clearDeliveryMethods();

        parent::afterDelete();
    }

    /**
     *
     */
    public function clearDeliveryMethods()
    {
        DeliveryPayment::model()->deleteAllByAttributes(['payment_id' => $this->id]);
    }

    /**
     * @param $settings
     */
    public function setPaymentSystemSettings($settings)
    {
        $this->_paymentSettings = $settings;
    }

    /**
     * @return array
     */
    public function getPaymentSystemSettings()
    {
        return $this->_paymentSettings;
    }

    /**
     * @param Order $order
     * @return string
     */
    public function getPaymentForm(Order $order)
    {
        $paymentSystem = Yii::app()->paymentManager->getPaymentSystemObject($this->module);

        return $paymentSystem ? $paymentSystem->renderCheckoutForm($this, $order, true) : null;
    }
}
