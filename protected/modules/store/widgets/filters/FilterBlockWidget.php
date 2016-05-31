<?php

/**
 * Class FilterBlockWidget
 */
class FilterBlockWidget extends \yupe\widgets\YWidget
{
    /**
     * @var string
     */
    public $view = 'filter-block';

    /**
     * @var
     */
    public $attributes;

    /**
     * @var
     */
    public $category;

    /**
     * @throws CException
     */
    public function run()
    {
        $this->render($this->view, ['attributes' => $this->attributes, 'category' => $this->category]);
    }
} 
