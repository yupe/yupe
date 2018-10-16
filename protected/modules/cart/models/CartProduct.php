<?php

/**
 * Class CartProduct
 */
class CartProduct extends Product implements IECartPosition
{
    /**
     * @param null|string $className
     * @return Good
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return mixed
     */
    public function getProductModel()
    {
        return Product::model()->findByPk($this->id);
    }
}
