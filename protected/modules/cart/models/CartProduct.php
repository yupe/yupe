<?php

class CartProduct extends Product implements IECartPosition
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getProductModel()
    {
        return Product::model()->findByPk($this->id);
    }
}
