<?php

class FilterBlockWidget extends \yupe\widgets\YWidget
{
    public $view = 'filter-block';

    public $attributes;

    public function run()
    {
        $this->render($this->view, ['attributes' => $this->attributes]);
    }
} 
