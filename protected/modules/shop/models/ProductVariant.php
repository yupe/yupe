<?php

/**
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $attribute_id
 * @property integer $option_id
 * @property string $value
 * @property double $amount
 * @property integer $type
 * @property string $sku
 *
 * @property-read Attribute $attribute
 * @property-read AttributeOption $option
 */
class ProductVariant extends \yupe\models\YModel
{
    const TYPE_SUM = 0;
    const TYPE_PERCENT = 1;
    const TYPE_BASE_PRICE = 2;

    public $amount = 0;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{shop_product_variant}}';
    }

    /**
     * Returns the static model of the specified AR class.
     * @return Attribute the static model class
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
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('attribute_id, product_id, amount, type', 'required'),
            array('id, attribute_id, option_id, product_id, type', 'numerical', 'integerOnly' => true),
            array('type', 'in', 'range' => array(self::TYPE_SUM, self::TYPE_PERCENT, self::TYPE_BASE_PRICE)),
            array('amount', 'numerical'),
            array('sku', 'length', 'max' => 50),
            array('value', 'length', 'max' => 250),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, attribute_id, option_id, value, product_id, amount, type, sku', 'safe', 'on' => 'search'),
        );
    }

    public function beforeValidate()
    {
        if (!$this->option_id && !$this->value)
        {
            $this->addErrors(array(
                    'option_id' => Yii::t('ShopModule.product', 'Необходимо указать значение варианта'),
                    'value' => Yii::t('ShopModule.product', 'Необходимо указать значение варианта'))
            );
        }
        return parent::beforeValidate();
    }

    public function relations()
    {
        return array(
            'attribute' => array(self::BELONGS_TO, 'Attribute', 'attribute_id'),
            'option' => array(self::BELONGS_TO, 'AttributeOption', 'option_id'),
        );
    }


    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('ShopModule.product', 'Id'),
            'product_id' => Yii::t('ShopModule.product', 'Продукт'),
            'attribute_id' => Yii::t('ShopModule.product', 'Атрибут'),
            'option_id' => Yii::t('ShopModule.product', 'Значение'),
            'type' => Yii::t('ShopModule.product', 'Тип стоимости'),
            'amount' => Yii::t('ShopModule.product', 'Стоимость'),
            'sku' => Yii::t('ShopModule.product', 'Артикул'),
        );
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return array(
            'is_main' => Yii::t('ShopModule.product', 'Главное'),
            'title' => Yii::t('ShopModule.product', 'Заголовок'),
        );
    }

    public function getTypeList()
    {
        return array(
            self::TYPE_SUM => Yii::t('ShopModule.product', 'Увеличение на сумму'),
            self::TYPE_PERCENT => Yii::t('ShopModule.product', 'Увеличение на процент'),
            self::TYPE_BASE_PRICE => Yii::t('ShopModule.product', 'Изменение базой цены'),
        );
    }

    public function getOptionValue($includeCost = true)
    {
        $value = "";
        switch ($this->attribute->type)
        {
            case Attribute::TYPE_DROPDOWN:
                $value = $this->option->value;
                break;
            case Attribute::TYPE_CHECKBOX:
                $value = $this->value ? Yii::t('ShopModule.product', 'Да') : Yii::t('ShopModule.product', 'Нет');
                break;
            case Attribute::TYPE_TEXT:
            case Attribute::TYPE_NUMBER:
                $value = $this->value;
                break;
        }
        if ($includeCost)
        {
            switch ($this->type)
            {
                case self::TYPE_SUM:
                    $value .= ' (' . ($this->amount > 0 ? '+' : '') . $this->amount . ' руб. к цене)';
                    break;
                case self::TYPE_PERCENT:
                    $value .= ' (' . ($this->amount > 0 ? '+' : '') . $this->amount . '% к цене)';
                    break;
                case self::TYPE_BASE_PRICE:
                    $value .= ' (цена: ' . $this->amount . ' руб.)';
                    break;
            }
        }
        return $value;
    }
}