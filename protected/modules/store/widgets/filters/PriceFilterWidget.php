<?php

/**
 * Class PriceFilterWidget
 */
class PriceFilterWidget extends \yupe\widgets\YWidget
{
    /**
     * @var string
     */
    public $view = 'price-filter';

    /**
     * @throws CException
     */
    public function run()
    {
        $this->render($this->view);
    }
}