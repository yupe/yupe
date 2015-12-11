<?php

/**
 * @property integer $id
 * @property integer $order_id
 * @property integer $product_id
 * @property string $product_name
 * @property string $variants
 * @property string $variants_text
 * @property double $price
 * @property integer $quantity
 * @property string $sku
 *
 * @property Order $order
 * @property Product $product
 */
class OrderProduct extends \yupe\models\YModel
{
    /* @var $variantIds Array - массив id вариантов, котороые нужно установить у продукта */
    public $variantIds = [];
    /**
     * @var array
     */
    private $oldVariants = [];
    /**
     * @var array
     */
    public $variantsArray = [];

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{store_order_product}}';
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
     * @return array
     */
    public function rules()
    {
        return [
            ['order_id', 'required'],
            ['product_name, sku', 'length', 'max' => 255],
            ['price', 'store\components\validators\NumberValidator'],
            ['variant_ids', 'safe'],
            ['quantity, order_id, product_id', 'numerical', 'integerOnly' => true],
        ];
    }

    /**
     * @return array
     */
    public function relations()
    {
        return [
            'order' => [self::BELONGS_TO, 'Order', 'order_id'],
            'product' => [self::BELONGS_TO, 'Product', 'product_id'],
        ];
    }

    /**
     *
     */
    public function afterFind()
    {
        $this->variantsArray = array_filter((array)unserialize($this->variants));
        foreach ($this->variantsArray as $var) {
            $this->oldVariants[] = $var;
        }
    }

    /**
     *
     */
    public function afterValidate()
    {
        parent::afterValidate();
        $this->variantIds = (array)$this->variantIds;
    }

    /**
     * @return bool
     */
    public function beforeSave()
    {
        if (Product::model()->exists('id = :product_id', [":product_id" => $this->product_id])) {
            $this->variantIds = array_filter($this->variantIds);

            // удаляем варианты, которые не были выбраны, старые не трогаем, чтобы оставить данные, на случай, если вариант был удален из системы
            foreach ($this->oldVariants as $key => $var) {
                if (!in_array($var['id'], $this->variantIds)) {
                    unset($this->oldVariants[$key]);
                }
            }
            $oldVariantIds = array_map(
                function ($x) {
                    return $x['id'];
                },
                $this->oldVariants
            );
            $newVariants = [];
            foreach ($this->variantIds as $varId) {
                if (!in_array($varId, $oldVariantIds)) {
                    /* @var $variant ProductVariant */
                    $variant = ProductVariant::model()->findByPk($varId);
                    if ($variant) {
                        // сохраняем информацию на случай удаления варианта из системы
                        $newVariants[] = array_merge(
                            $variant->attributes,
                            [
                                'attribute_name' => $variant->attribute->name,
                                'attribute_title' => $variant->attribute->title,
                                'optionValue' => $variant->getOptionValue(),
                            ]
                        );
                    }
                }
            }
            $combinedVariants = array_merge($this->oldVariants, $newVariants);
            $this->variants = serialize($combinedVariants);
        }

        return parent::beforeSave();
    }

    /**
     * @return float
     */
    public function getTotalPrice()
    {
        return (float)$this->price * $this->quantity;
    }

    public function attributeLabels()
    {
        return [
            'sku' => Yii::t('OrderModule.order', 'Sku'),
            'product_name' => Yii::t('OrderModule.order', 'Product'),
            'quantity' => Yii::t('OrderModule.order', 'Quantity'),
            'price' => Yii::t('OrderModule.order', 'Price')
        ];
    }
}
