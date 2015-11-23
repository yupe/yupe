<?php

/**
 * Class FavoriteServiceEvent
 */
class FavoriteServiceEvent extends \yupe\components\Event
{
    /**
     * @var Product
     */
    protected $product;

    /**
     * @var CHttpSession
     */
    protected $session;

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    /**
     * @return mixed
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param mixed $session
     */
    public function setSession($session)
    {
        $this->session = $session;
    }

    /**
     * FavoriteServiceEvent constructor.
     * @param $product
     * @param $session
     */
    public function __construct(Product $product, CHttpSession $session)
    {
        $this->product = $product;
        $this->session = $session;
    }
}