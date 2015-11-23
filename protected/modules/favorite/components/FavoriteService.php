<?php

Yii::import('application.modules.favorite.events.*');

/**
 * Class FavoriteService
 */
class FavoriteService extends CApplicationComponent
{
    /**
     * @var string
     */
    public $key = 'yupe::store::favorites';

    /**
     * @var CHttpSession
     */
    protected $session;

    /**
     * @return mixed|null
     */
    protected function getData()
    {
        return $this->session->get($this->key);
    }


    protected function setData(array $data)
    {
        $this->session->add($this->key, $data);
        return true;
    }

    /**
     *
     */
    public function init()
    {
        $this->session = Yii::app()->getSession();

        if (null === $this->session->get($this->key)) {
            $this->session->add($this->key, []);
        }
    }


    /**
     * @param Product $product
     * @return bool
     */
    public function add(Product $product)
    {
        $products = $this->getData();

        if(isset($products[$product->id])) {
            return false;
        }

        $products[$product->id] = time();

        $this->setData($products);

        Yii::app()->eventManager->fire(FavoriteEvents::ADD_TO_FAVORITE, new FavoriteServiceEvent($product, $this->session));

        return true;
    }


    public function remove($productId)
    {
        $products = $this->getData();

        if(isset($products[$productId])) {
            isset($products[$productId]);
            return $this->setData($products);
        }

        return false;
    }

    /**
     *
     */
    public function count()
    {
        $products = $this->getData();

        return count($products);
    }

    /**
     * @param Product $product
     * @return bool
     */
    public function has(Product $product)
    {
        $products = $this->getData();

        return isset($products[$product->id]);
    }
}