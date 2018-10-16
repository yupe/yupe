<?php
use yupe\widgets\YWidget;

/**
 * Class SizeFilterWidget
 */
class SizeFilterWidget extends YWidget
{
    /**
     * @var string
     */
    public $view = 'size-filter';

    /**
     * @throws CException
     */
    public function run()
    {
        $this->render($this->view);
    }
}