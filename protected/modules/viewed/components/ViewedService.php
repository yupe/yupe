<?php

class ViewedService extends CApplicationComponent
{
    /**
     * @var string
     */
    public $key = 'yupe::store::viewed';

    /**
     * @var CHttpSession
     */
    protected $session;

    public function init()
    {
        $this->session = Yii::app()->getSession();

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
        if ($this->has($productId)) {
            return false;
        }

        $products = $this->get();

        $products[$productId] = time();

        $this->set($products);

        return true;
    }

    /**
     * @param $productId
     * @return bool
     */
    public function has($productId)
    {
        $products = $this->get();

        return isset($products[$productId]);
    }

    /**
     * @return mixed|null
     */
    public function get()
    {
        return $this->session->get($this->key);
    }

    public function count()
    {
        return count($this->get());
    }

    /**
     * @param array $data
     * @return bool
     */
    protected function set(array $data)
    {
        $this->session->add($this->key, $data);

        return true;
    }
}