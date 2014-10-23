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
    /* @var $variant_ids Array - массив id вариантов, котороые нужно установить у продукта */
    public $variant_ids = array();
    private $oldVariants = array();
    public $variantsArray = array();

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{store_order_product}}';
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function rules()
    {
        return array(
            array('order_id', 'required'),
            array('product_name, sku', 'length', 'max' => 255),
            array('price', 'store\components\validators\NumberValidator'),
            array('variant_ids', 'safe'),
            array('quantity, order_id, product_id', 'numerical', 'integerOnly' => true),
        );
    }

    public function relations()
    {
        return array(
            'order' => array(self::BELONGS_TO, 'Order', 'order_id'),
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
        );
    }

    public function afterFind()
    {
        $this->variantsArray = array_filter((array)unserialize($this->variants));
        foreach ($this->variantsArray as $var) {
            $this->oldVariants[] = $var;
        }
    }

    public function afterValidate()
    {
        parent::afterValidate();
        $this->variant_ids = (array)$this->variant_ids;
    }

    public function beforeSave()
    {
        if (Product::model()->exists('id = :product_id', array(":product_id" => $this->product_id))) {
            $this->variant_ids = array_filter($this->variant_ids);

            // удаляем варианты, которые не были выбраны, старые не трогаем, чтобы оставить данные, на случай, если вариант был удален из системы
            foreach ($this->oldVariants as $key => $var) {
                if (!in_array($var['id'], $this->variant_ids)) {
                    unset($this->oldVariants[$key]);
                }
            }
            $oldVariantIds = array_map(
                function ($x) {
                    return $x['id'];
                },
                $this->oldVariants
            );
            $newVariants = array();
            foreach ($this->variant_ids as $varId) {
                if (!in_array($varId, $oldVariantIds)) {
                    /* @var $variant ProductVariant */
                    $variant = ProductVariant::model()->findByPk($varId);
                    if ($variant) {
                        // сохраняем информацию на случай удаления варианта из системы
                        $newVariants[] = array_merge(
                            $variant->attributes,
                            array(
                                'attribute_name' => $variant->attribute->name,
                                'attribute_title' => $variant->attribute->title,
                                'optionValue' => $variant->getOptionValue(),
                            )
                        );
                    }
                }
            }
            $combinedVariants = array_merge($this->oldVariants, $newVariants);
            $this->variants = serialize($combinedVariants);
        }
        return parent::beforeSave();
    }

    public function getTotalPrice()
    {
        return (float)$this->price * $this->quantity;
    }
}
