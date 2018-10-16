<?php

/**
 * Class CartEvent
 */
class CartEvent extends \yupe\components\Event
{
    /**
     * @var
     */
    protected $user;

    /**
     * @var
     */
    protected $cart;

    /**
     * CartEvent constructor.
     * @param IWebUser $user
     * @param EShoppingCart $cart
     */
    public function __construct(IWebUser $user, EShoppingCart $cart)
    {
        $this->user = $user;
        $this->cart = $cart;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @param mixed $cart
     */
    public function setCart($cart)
    {
        $this->cart = $cart;
    }
}