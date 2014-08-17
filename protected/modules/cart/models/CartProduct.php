<?php

class CartProduct extends Product implements IECartPosition
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
