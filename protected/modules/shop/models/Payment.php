<?php

/**
 * This is the model class for table "shop_payment".
 *
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

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{shop_payment}}';
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
            array('name, module, position, status', 'required'),
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
            'id' => Yii::t('ShopModule.payment', 'ID'),
            'name' => Yii::t('ShopModule.payment', 'Название'),
            'description' => Yii::t('ShopModule.payment', 'Описание'),
            'status' => Yii::t('ShopModule.payment', 'Статус'),
            'position' => Yii::t('ShopModule.payment', 'Позиция'),
            'module' => Yii::t('ShopModule.payment', 'Платежная система'),
            'currency_id' => Yii::t('ShopModule.payment', 'Валюта'),
            'settings' => Yii::t('ShopModule.payment', 'Настройки платежной системы'),
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

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array('defaultOrder' => 't.position')
        ));
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_ACTIVE => 'Активен',
            self::STATUS_NOT_ACTIVE => 'Неактивен',
        );
    }

    public function getStatusTitle()
    {
        $data = $this->getStatusList();
        return isset($data[$this->status]) ? $data[$this->status] : '*неизвестен*';
    }

    public function sort(array $items)
    {
        $transaction = Yii::app()->db->beginTransaction();
        try
        {
            foreach ($items as $id => $priority)
            {
                $model = $this->findByPk($id);
                if (null === $model)
                {
                    continue;
                }
                $model->position = (int)$priority;

                if (!$model->update('sort'))
                {
                    throw new CDbException('Error sort menu items!');
                }
            }
            $transaction->commit();
            return true;
        } catch (Exception $e)
        {
            $transaction->rollback();
            return false;
        }
    }

    public function afterDelete()
    {
        DeliveryPayment::model()->deleteAllByAttributes(array('payment_id' => $this->id));
    }
}
