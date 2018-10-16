<?php
/**
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $category_id
 * @property integer $is_main
 *
 */
class ProductCategory extends \yupe\models\YModel
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{store_product_category}}';
    }

    /**
     * @param null|string $className
     * @return $this
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
