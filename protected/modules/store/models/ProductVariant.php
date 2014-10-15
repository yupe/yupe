<?php

/**
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $attribute_id
 * @property string $attribute_value
 * @property double $amount
 * @property integer $type
 * @property string $sku
 *
 * @property-read Attribute $attribute
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
        return '{{store_product_variant}}';
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
        return array(
            array('attribute_id, product_id, amount, type', 'required'),
            array('id, attribute_id, product_id, type', 'numerical', 'integerOnly' => true),
            array('type', 'in', 'range' => array(self::TYPE_SUM, self::TYPE_PERCENT, self::TYPE_BASE_PRICE)),
            array('amount', 'numerical'),
            array('sku', 'length', 'max' => 50),
            array('attribute_value', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, attribute_id, attribute_value, product_id, amount, type, sku', 'safe', 'on' => 'search'),
        );
    }

    public function beforeValidate()
    {
        if (!$this->attribute_value) {
            $this->addErrors(
                array(
                    'attribute_value' => Yii::t('StoreModule.product', 'Необходимо указать значение атрибута')
                )
            );
        }
        return parent::beforeValidate();
    }

    public function relations()
    {
        return array(
            'attribute' => array(self::BELONGS_TO, 'Attribute', 'attribute_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('StoreModule.product', 'Id'),
            'product_id' => Yii::t('StoreModule.product', 'Продукт'),
            'attribute_id' => Yii::t('StoreModule.product', 'Атрибут'),
            'attribute_value' => Yii::t('StoreModule.product', 'Значение атрибута'),
            'type' => Yii::t('StoreModule.product', 'Тип стоимости'),
            'amount' => Yii::t('StoreModule.product', 'Стоимость'),
            'sku' => Yii::t('StoreModule.product', 'Артикул'),
        );
    }

    public function getTypeList()
    {
        return array(
            self::TYPE_SUM => Yii::t('StoreModule.product', 'Увеличение на сумму'),
            self::TYPE_PERCENT => Yii::t('StoreModule.product', 'Увеличение на процент'),
            self::TYPE_BASE_PRICE => Yii::t('StoreModule.product', 'Изменение базой цены'),
        );
    }

    public function getOptionValue($includeCost = false)
    {
        $value = "";
        switch ($this->attribute->type) {
            case Attribute::TYPE_CHECKBOX:
                $value = $this->attribute_value ? Yii::t('StoreModule.product', 'Да') : Yii::t('StoreModule.product', 'Нет');
                break;
            case Attribute::TYPE_DROPDOWN:
            case Attribute::TYPE_TEXT:
            case Attribute::TYPE_NUMBER:
                $value = $this->attribute_value;
                break;
        }
        if ($includeCost) {
            switch ($this->type) {
                case self::TYPE_SUM:
                    $value .= ' (' . ($this->amount > 0 ? '+' : '') . $this->amount . ' ' . Yii::t("StoreModule.product", 'руб. к цене') . ')';
                    break;
                case self::TYPE_PERCENT:
                    $value .= ' (' . ($this->amount > 0 ? '+' : '') . $this->amount . Yii::t("StoreModule.product", '% к цене') . ')';
                    break;
                case self::TYPE_BASE_PRICE:
                    $value .= ' (' . Yii::t("StoreModule.product", 'цена') . ': ' . $this->amount . ' ' . Yii::t("StoreModule.product", 'руб') . '.)';
                    break;
            }
        }
        return $value;
    }
}
