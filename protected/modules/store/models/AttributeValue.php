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
 * @property Attribute $attribute
 * @property Product $product
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
        return [
            ['product_id, attribute_id', 'required'],
            ['product_id, attribute_id, option_value', 'numerical', 'integerOnly' => true],
            ['number_value', 'numerical'],
            ['string_value', 'length', 'max' => 250],
            ['text_value', 'safe'],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'attribute' => [self::BELONGS_TO, 'Attribute', 'attribute_id'],
            'product' => [self::BELONGS_TO, 'Product', 'product_id'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product',
            'attribute_id' => 'Attribute',
            'number_value' => 'Int Value',
            'string_value' => 'Str Value',
            'text_value' => 'Text Value',
            'option_value' => 'Option value',
            'create_time' => 'Create time',
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
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('attribute_id', $this->attribute_id);
        $criteria->compare('int_value', $this->int_value);
        $criteria->compare('str_value', $this->str_value, true);
        $criteria->compare('text_value', $this->text_value, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
        ]);
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
            case Attribute::TYPE_CHECKBOX_LIST:
                $this->option_value = empty($value) ? null : (int)$value;
                break;
            case Attribute::TYPE_CHECKBOX:
                $this->number_value = empty($value) ? 0 : 1;
                break;
            case Attribute::TYPE_NUMBER:
                $this->number_value = $value === '' ? null : (float)$value;
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
                return is_null($this->option_value) ? null : (int)$this->option_value;
            case Attribute::TYPE_CHECKBOX_LIST:
                return is_null($this->option_value) ? null : (int)$this->option_value;
            case Attribute::TYPE_CHECKBOX:
                return (bool)$this->number_value;
            case Attribute::TYPE_NUMBER:
                return is_null($this->number_value) ? null : (float)$this->number_value;
            case Attribute::TYPE_TEXT:
                return $this->text_value;
            case Attribute::TYPE_SHORT_TEXT:
                return $this->string_value;
            case Attribute::TYPE_FILE:
                return $this->string_value;
            default:
                return $default;
        }
    }


    /**
     * @param $type
     * @return string
     */
    public function column($type)
    {
        $type = (int)$type;

        $map = [
            Attribute::TYPE_DROPDOWN => 'option_value',
            Attribute::TYPE_CHECKBOX => 'number_value',
            Attribute::TYPE_NUMBER => 'number_value',
            Attribute::TYPE_TEXT => 'text_value',
            Attribute::TYPE_SHORT_TEXT => 'string_value',
            Attribute::TYPE_CHECKBOX_LIST => 'option_value'
        ];

        return array_key_exists($type, $map) ? $map[$type] : 'string_value';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'file-upload' => [
                'class' => 'yupe\components\behaviors\FileUploadBehavior',
                'attributeName' => 'string_value',
                'uploadPath' => Yii::app()->getModule('store')->uploadPath.'/product',
            ],
        ];
    }

    /**
     * @return null|string
     */
    public function getFilePath()
    {
        if (!$this->attribute->isType(Attribute::TYPE_FILE)) {
            return null;
        }

        $file = Yii::app()->getBasePath().'/'.Yii::app()->getModule('yupe')->uploadPath.'/'.Yii::app()->getModule('store')->uploadPath.'/product/'.$this->value();

        return \yupe\helpers\YFile::rmFile($file);
    }
}
