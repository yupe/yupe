<?php
class CategoryFilterWidget extends \yupe\widgets\YWidget
{
    public $view = 'category-filter';

    public function run()
    {
        $this->render($this->view, ['categories' => StoreCategory::model()->roots()->published()->cache($this->cacheTime)->findAll(['order' => 'sort'])]);
    }
} 
