<?php
class PriceFilterWidget extends \yupe\widgets\YWidget
{
    public $view = 'price-filter';

    public function run()
    {
        $this->render($this->view);
    }
}