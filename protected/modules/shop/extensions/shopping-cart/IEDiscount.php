<?php
/**
 * Discount abstract class
 *
 * @author pirrat <mrakobesov@gmail.com>
 * @version 0.9
 * @package ShoppingCart
 *
 */
abstract class IEDiscount {

    protected $shoppingCart;

    public function setShoppingCart(EShoppingCart $shoppingCart) {
        $this->shoppingCart = $shoppingCart;
    }

    /**
     * Apply discount
     *
     * @abstract
     * @return void
     */
    abstract public function apply();

}
