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
     * @var
     */
    public $category;

    /**
     * @throws CException
     */
    public function run()
    {
        $categories = $this->category ? $this->category->child() : StoreCategory::model()->roots();

        $this->render($this->view, [
            'categories' => $categories->published()->findAll([
                'order' => 'sort',
                'limit' => $this->limit,
            ]),
        ]);
    }
} 
