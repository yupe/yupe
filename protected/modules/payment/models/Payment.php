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
    const STATUS_ACTIVE = 1;
    const STATUS_NOT_ACTIVE = 0;

    private $_paymentSettings = array();

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{store_payment}}';
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
            array('name, position, status', 'required'),
            array('name', 'filter', 'filter' => 'trim'),
            array('currency_id', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 255),
            array('module', 'length', 'max' => 100),
            array('description', 'safe'),
            array('status', 'in', 'range' => array_keys($this->getStatusList())),
            array('id, module, name, description, settings, currency_id, position, status', 'safe', 'on' => 'search'),
        );
    }

    public function scopes()
    {
        return array(
            'published' => array(
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
            'id' => Yii::t('PaymentModule.payment', 'ID'),
            'name' => Yii::t('PaymentModule.payment', 'Название'),
            'description' => Yii::t('PaymentModule.payment', 'Описание'),
            'status' => Yii::t('PaymentModule.payment', 'Статус'),
            'position' => Yii::t('PaymentModule.payment', 'Позиция'),
            'module' => Yii::t('PaymentModule.payment', 'Платежная система'),
            'currency_id' => Yii::t('PaymentModule.payment', 'Валюта'),
            'settings' => Yii::t('PaymentModule.payment', 'Настройки платежной системы'),
        );
    }


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
            $this, array(
                'criteria' => $criteria,
                'sort' => array('defaultOrder' => 't.position')
            )
        );
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_ACTIVE => Yii::t("PaymentModule.payment", 'Активен'),
            self::STATUS_NOT_ACTIVE => Yii::t("PaymentModule.payment", 'Неактивен'),
        );
    }

    public function getStatusTitle()
    {
        $data = $this->getStatusList();
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t("PaymentModule.payment", '*неизвестен*');
    }

    public function sort(array $items)
    {
        $transaction = Yii::app()->db->beginTransaction();
        try {
            foreach ($items as $id => $priority) {
                $model = $this->findByPk($id);
                if (null === $model) {
                    continue;
                }
                $model->position = (int)$priority;

                if (!$model->update('sort')) {
                    throw new CDbException('Error sort menu items!');
                }
            }
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollback();
            return false;
        }
    }

    public function beforeSave()
    {
        $this->settings = serialize($this->_paymentSettings);
        return parent::beforeSave();
    }

    public function afterFind()
    {
        $this->_paymentSettings = unserialize($this->settings);
        parent::afterFind();
    }

    public function afterDelete()
    {
        if (Yii::app()->hasModule('delivery')) {
            $this->clearDeliveryMethods();
        }
        parent::afterDelete();
    }

    public function clearDeliveryMethods()
    {
        DeliveryPayment::model()->deleteAllByAttributes(array('payment_id' => $this->id));
    }

    public function setPaymentSystemSettings($settings)
    {
        $this->_paymentSettings = $settings;
    }

    public function getPaymentSystemSettings()
    {
        return $this->_paymentSettings;
    }

    public function getPaymentForm(Order $order)
    {
        $paymentSystem = Yii::app()->paymentManager->getPaymentSystemObject($this->module);

        return $paymentSystem ? $paymentSystem->renderCheckoutForm($this, $order, true) : "";
    }
}
