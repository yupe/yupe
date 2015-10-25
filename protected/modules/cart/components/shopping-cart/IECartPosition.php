<?php

/**
 * IECartPosition
 *
 * @author pirrat <mrakobesov@gmail.com>
 * @version 0.9
 * @package ShoppingCart
 */
interface IECartPosition
{
    /**
     * @return mixed id
     */
    public function getId();

    /**
     * @return float price
     */
    public function getPrice();
}
