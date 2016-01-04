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
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @return mixed|null
     */
    protected function getData()
    {
        return $this->session->get($this->key);
    }


    /**
     * @param array $data
     * @return bool
     */
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

        $this->productRepository = Yii::app()->getComponent('productRepository');

        if (null === $this->session->get($this->key)) {
            $this->session->add($this->key, []);
        }
    }


    /**
     * @param $productId
     * @return bool
     */
    public function add($productId)
    {
        $products = $this->getData();

        $products[$productId] = time();

        $this->setData($products);

        Yii::app()->eventManager->fire(
            FavoriteEvents::ADD_TO_FAVORITE,
            new FavoriteServiceEvent($productId, $this->session)
        );

        return true;
    }


    /**
     * @param $productId
     * @return bool
     */
    public function remove($productId)
    {
        $products = $this->getData();

        if (isset($products[$productId])) {
            unset($products[$productId]);
            Yii::app()->eventManager->fire(
                FavoriteEvents::REMOVE_FROM_FAVORITE,
                new FavoriteServiceEvent($productId, $this->session)
            );

            return $this->setData($products);
        }

        return false;
    }

    /**
     *
     */
    public function count()
    {
        return count($this->getData());
    }

    /**
     * @param $productId
     * @return bool
     */
    public function has($productId)
    {
        $products = $this->getData();

        return isset($products[$productId]);
    }

    /**
     * @return mixed
     */
    public function products()
    {
        return $this->productRepository->getByIds(array_keys($this->getData()));
    }
}