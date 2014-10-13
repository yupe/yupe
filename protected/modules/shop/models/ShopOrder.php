<?php
Yii::import('catalog.models.Good');//связь с товарами

/**
 * This is the model class for table "{{shop_order}}".
 *
 * The followings are the available columns in table '{{shop_order}}':
 * @property integer $id
 * @property string $price
 * @property string $address
 * @property string $recipient
 * @property string $phone
 * @property string $create_time
 *
 * @property Good[] $goods
 */
class ShopOrder extends yupe\models\YModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shop_order}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('price, recipient, phone', 'required'),
            array('address', 'required', 'on' => 'update'),// это когда адрес у клиента выясняешь
			array('price', 'length', 'max'=>19),
			array('recipient, phone', 'length', 'max'=>255),
			// The following rule is used by search().
			array('id, price, address, recipient, phone, create_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'orderGoods' => array(self::HAS_MANY, 'ShopOrderGood', 'order_id'),
            'goods' => array(self::HAS_MANY, 'Good', 'order_id', 'through' => 'orderGoods'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Номер заказа',
			'price' => 'Стоимость',
			'formattedPrice' => 'Стоимость',
			'address' => 'Адрес',
			'recipient' => 'Имя',
			'phone' => 'Телефон',
            'create_time' => 'Дата создания'
		);
	}


    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class'             => 'zii.behaviors.CTimestampBehavior',
                'setUpdateOnCreate' => false,
                'createAttribute'   => 'create_time',
                'updateAttribute'   => null,
            ),
        );
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('recipient',$this->recipient,true);
		$criteria->compare('phone',$this->phone,true);
        $data = Yii::app()->dateFormatter->format('yyyy-MM-dd',$this->create_time);
		$criteria->compare(
            'create_time',
            Yii::app()->dateFormatter->format('yyyy-MM-dd',$this->create_time),
            true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShopOrder the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * Добавить товар к заказу
     * @param Good $good
     * @return bool результат сохранения orderGood
     */
    public function addGood(Good $good)
    {
        $orderGood = new ShopOrderGood();
        $orderGood->price = $good->price;
        $orderGood->catalog_good_id = $good->id;
        $orderGood->order_id = $this->id;
        return $orderGood->save();
    }

    public function getFormattedPrice() {
        return Yii::app()->numberFormatter->formatCurrency($this->price, 'RUR');
    }
}
