<?php

/**
 * Class LinkedProductsWidget
 */
class LinkedProductsWidget extends \yupe\widgets\YWidget
{
    /**
     * @var string
     */
    public $view = 'linked-products';

    /**
     * @var null
     */
    public $code = null;
    /**
     * @var Product
     */
    public $product;

    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     *
     */
    public function init()
    {
        $this->productRepository = new ProductRepository();
    }

    /**
     * @throws CException
     */
    public function run()
    {
        if (!$this->product) {
            return;
        }

        $this->render($this->view,
            ['dataProvider' => $this->productRepository->getLinkedProductsDataProvider($this->product, $this->code)]);
    }
} 
