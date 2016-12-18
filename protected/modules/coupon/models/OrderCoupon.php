<?php

/**
 * This is the model class for table "{{store_order_coupon}}".
 *
 * The followings are the available columns in table '{{store_order_coupon}}':
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $coupon_id
 * @property string $create_time
 *
 * The followings are the available model relations:
 * @property Coupon $coupon
 * @property Order $order
 */
class OrderCoupon extends \yupe\models\YModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{store_order_coupon}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
			['order_id, coupon_id, create_time', 'required'],
			['order_id, coupon_id', 'numerical', 'integerOnly' => true],
			['id, order_id, coupon_id, create_time', 'safe', 'on' => 'search'],
		];
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return [
			'coupon' => [self::BELONGS_TO, 'Coupon', 'coupon_id'],
			'order' => [self::BELONGS_TO, 'Order', 'order_id'],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'order_id' => 'Order',
			'coupon_id' => Yii::t('CouponModule.coupon', 'Code'),
			'create_time' => Yii::t('CouponModule.coupon', 'Create time'),
		];
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
	    $criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('order_id', $this->order_id);
		$criteria->compare('coupon_id', $this->coupon_id);
		$criteria->compare('create_time', $this->create_time, true);

		return new CActiveDataProvider($this, [
			'criteria' => $criteria,
		]);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 *
	 * @param string $className active record class name.
	 * @return OrderCoupon the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
}
