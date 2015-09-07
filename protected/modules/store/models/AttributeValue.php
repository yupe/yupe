<?php

/**
 * This is the model class for table "{{store_product_attribute_value}}".
 *
 * The followings are the available columns in table '{{store_product_attribute_value}}':
 * @property integer $id
 * @property integer $product_id
 * @property integer $attribute_id
 * @property integer $int_value
 * @property string $str_value
 * @property string $text_value
 *
 * The followings are the available model relations:
 * @property StoreAttribute $attribute
 * @property StoreProduct $product
 */
class AttributeValue extends yupe\models\YModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{store_product_attribute_value}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, attribute_id', 'required'),
			array('product_id, attribute_id, int_value', 'numerical', 'integerOnly'=>true),
			array('str_value', 'length', 'max'=>250),
			array('text_value', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, product_id, attribute_id, int_value, str_value, text_value', 'safe', 'on'=>'search'),
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
			'attribute' => array(self::BELONGS_TO, 'StoreAttribute', 'attribute_id'),
			'product' => array(self::BELONGS_TO, 'StoreProduct', 'product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'product_id' => 'Product',
			'attribute_id' => 'Attribute',
			'int_value' => 'Int Value',
			'str_value' => 'Str Value',
			'text_value' => 'Text Value',
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
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('attribute_id',$this->attribute_id);
		$criteria->compare('int_value',$this->int_value);
		$criteria->compare('str_value',$this->str_value,true);
		$criteria->compare('text_value',$this->text_value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AttributeValue the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
