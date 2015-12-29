<?php

/**
 * Class CategoryFilterWidget
 */
class CategoryFilterWidget extends \yupe\widgets\YWidget
{
    /**
     * @var string
     */
    public $view = 'category-filter';

    /**
     * @throws CException
     */
    public function run()
    {
        $this->render($this->view, ['categories' => StoreCategory::model()->roots()->published()->cache($this->cacheTime)->findAll(['order' => 'sort'])]);
    }
} 
