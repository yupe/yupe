<?php

class LinkedProductsWidget extends \yupe\widgets\YWidget
{
    public $view = 'linked-products';

    public $code = null;
    /**
     * @var Product
     */
    public $product;

    public function run()
    {
        if (!$this->product) {
            return;
        }

        $this->render($this->view, ['dataProvider' => $this->product->getLinkedProductsDataProvider($this->code)]);
    }
} 
