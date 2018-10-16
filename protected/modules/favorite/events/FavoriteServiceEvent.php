<?php

/**
 * Class FavoriteServiceEvent
 */
class FavoriteServiceEvent extends \yupe\components\Event
{
    /**
     * @var
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
     * @param $productId
     * @param CHttpSession $session
     */
    public function __construct($productId, CHttpSession $session)
    {
        $this->product = $productId;
        $this->session = $session;
    }
}