<?php

/**
 * This is the model class for table "{{store_product_attribute_value}}".
 *
 * The followings are the available columns in table '{{store_product_attribute_value}}':
 * @property integer $id
 * @property integer $product_id
 * @property integer $attribute_id
 * @property integer $number_value
 * @property string $string_value
 * @property string $text_value
 * @property integer $option_value
 * @property string $create_time
 *
 * The followings are the available model relations:
 * @property StoreAttribute $attribute
 * @property StoreProduct $product
 */
class AttributeValue extends yupe\models\YModel
{
    /**
     * @var array
     */
    private $attributes = [];

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
            array('product_id, attribute_id, option_value', 'numerical', 'integerOnly' => true),
            array('number_value', 'numerical'),
            array('string_value', 'length', 'max' => 250),
            array('text_value', 'safe')
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
            'attribute' => array(self::BELONGS_TO, 'Attribute', 'attribute_id'),
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
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
            'number_value' => 'Int Value',
            'string_value' => 'Str Value',
            'text_value' => 'Text Value',
            'option_value' => 'Option value',
            'create_time' => 'Create time'
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('attribute_id', $this->attribute_id);
        $criteria->compare('int_value', $this->int_value);
        $criteria->compare('str_value', $this->str_value, true);
        $criteria->compare('text_value', $this->text_value, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AttributeValue the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @param $attributeId
     * @param $value
     * @param Product $product
     * @return bool
     */
    public function store($attributeId, $value, Product $product)
    {
        $attribute = null;

        if (!isset($this->attributes[$attributeId])) {
            $attribute = Attribute::model()->findByPk($attributeId);
            $this->attributes[$attributeId] = $attribute;
        } else {
            $attribute = $this->attributes[$attributeId];
        }

        switch ($attribute->type) {
            case Attribute::TYPE_DROPDOWN:
                $this->option_value = empty($value) ? null : (int)$value;
                break;
            case Attribute::TYPE_CHECKBOX:
                $this->number_value = (bool)$value;
                break;
            case Attribute::TYPE_NUMBER:
                $this->number_value = empty($value) ? null : (float)$value;
                break;
            case Attribute::TYPE_TEXT:
                $this->text_value = $value;
                break;
            case Attribute::TYPE_SHORT_TEXT:
                $this->string_value = $value;
                break;
            default:
                throw new InvalidArgumentException('Error attribute!');
        }

        $this->product_id = $product->id;
        $this->attribute_id = $attribute->id;

        return $this->save();
    }

    /**
     * @param null $default
     * @return bool|float|int|null|string
     */
    public function value($default = null)
    {
        switch ($this->attribute->type) {
            case Attribute::TYPE_DROPDOWN:
                return (int)$this->option_value;
                break;
            case Attribute::TYPE_CHECKBOX:
                return (bool)$this->number_value;
                break;
            case Attribute::TYPE_NUMBER:
                return (float)$this->number_value;
                break;
            case Attribute::TYPE_TEXT:
                return $this->text_value;
                break;
            case Attribute::TYPE_SHORT_TEXT:
                return $this->string_value;
                break;
            default:
                return $default;
        }
    }


    public function column($type)
    {
        $type = (int)$type;

        $map = [
            Attribute::TYPE_DROPDOWN => 'option_value',
            Attribute::TYPE_CHECKBOX => 'number_value',
            Attribute::TYPE_NUMBER => 'number_value',
            Attribute::TYPE_TEXT => 'text_value',
            Attribute::TYPE_SHORT_TEXT => 'string_value'
        ];

        return array_key_exists($type, $map) ? $map[$type] : 'string_value';
    }
}
