<?php

/**
 * Class ProductBatchForm
 */
class ProductBatchForm extends CFormModel
{
    /**
     * @var int
     */
    public $status;

    /**
     * @var int
     */
    public $in_stock;

    /**
     * @var bool
     */
    public $is_special;

    /**
     * @var int
     */
    public $quantity;

    /**
     * @var int
     */
    public $producer_id;

    /**
     * @var int
     */
    public $category_id;

    /**
     * @var string
     */
    public $view;

    /**
     * @var float
     */
    public $price;

    /**
     * @var int
     */
    public $price_op;

    /**
     * @var int
     */
    public $price_op_unit;

    /**
     * @var
     */
    public $discount_price;

    /**
     * @var int
     */
    public $discount_price_op;

    /**
     * @var int
     */
    public $discount_price_op_unit;

    /**
     * @var
     */
    public $discount;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['status, in_stock, quantity, producer_id, price_op, price_op_unit, discount_price_op, discount_price_op_unit', 'numerical', 'integerOnly' => true],
            ['status', 'in', 'range' => array_keys(Product::model()->getStatusList())],
            ['in_stock', 'in', 'range' => array_keys(Product::model()->getInStockList())],
            ['price_op, discount_price_op', 'in', 'range' => array_keys(ProductBatchHelper::getPericeOpList())],
            ['price_op_unit, discount_price_op_unit', 'in', 'range' => array_keys(ProductBatchHelper::getOpUnits())],
            ['price, discount_price', 'store\components\validators\NumberValidator'],
            ['is_special', 'boolean'],
            ['producer_id', 'exist', 'attributeName' => 'id', 'className' => 'Producer'],
            ['category_id', 'exist', 'attributeName' => 'id', 'className' => 'StoreCategory'],
            ['view', 'length', 'max' => 100],
            ['view', 'filter', 'filter' => 'trim'],
            ['view', 'filter', 'filter' => 'strip_tags'],
            ['status, in_stock, quantity, producer_id, is_special, category_id, view, price, discount_price, discount', 'default', 'value' => null],
            ['discount', 'numerical', 'integerOnly' => true, 'max' => 100],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'status' => Yii::t('StoreModule.store', 'Status'),
            'in_stock' => Yii::t('StoreModule.store', 'Stock status'),
            'is_special' => Yii::t('StoreModule.store', 'Special'),
            'quantity' => Yii::t('StoreModule.store', 'Quantity'),
            'producer_id' => Yii::t('StoreModule.store', 'Producer'),
            'category_id' => Yii::t('StoreModule.store', 'Category'),
            'view' => Yii::t('StoreModule.store', 'Template'),
            'price' => Yii::t('StoreModule.store', 'Price'),
            'discount_price' => Yii::t('StoreModule.store', 'Discount price'),
            'discount' => Yii::t('StoreModule.store', 'Discount, %'),
        ];
    }

    /**
     * @return array
     */
    public function loadQueryAttributes()
    {
        $result = [];
        $allowed = ['status', 'in_stock', 'is_special', 'quantity', 'producer_id', 'category_id', 'view', 'discount'];
        $attributes = $this->getAttributes();

        foreach ($attributes as $name => $value) {
            if (in_array($name, $allowed) && null !== $value) {
                $result[$name] = $value;
            }
        }

        return $result;
    }
}