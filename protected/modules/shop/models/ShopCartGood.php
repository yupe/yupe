<?php
Yii::import('catalog.models.Good');

/**
 * This is the model class for table "{{shop_cart_good}}".
 *
 * The followings are the available columns in table '{{shop_cart_good}}':
 * @property integer $id
 * @property integer $cart_id
 * @property integer $catalog_good_id
 *
 * The followings are the available model relations:
 * @property Good $catalogGood
 * @property ShopCart $cart
 */
class ShopCartGood extends yupe\models\YModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shop_cart_good}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cart_id, catalog_good_id', 'required'),
			array('cart_id, catalog_good_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			array('id, cart_id, catalog_good_id', 'safe', 'on'=>'search'),
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
			'catalogGood' => array(self::BELONGS_TO, 'Good', 'catalog_good_id'),
			'cart' => array(self::BELONGS_TO, 'ShopCart', 'cart_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cart_id' => 'cart',
			'catalog_good_id' => 'Catalog Good',
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
		$criteria->compare('cart_id',$this->cart_id);
		$criteria->compare('catalog_good_id',$this->catalog_good_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShopCartGood the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
