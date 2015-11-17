<?php

Yii::import('application.modules.store.forms.SearchForm');

/**
 * Class SearchProductWidget
 */
class SearchProductWidget extends \yupe\widgets\YWidget
{
    /**
     * @var string
     */
    public $view = 'search-product-form';

    /**
     * @var
     */
    public $query;

    /**
     * @var
     */
    public $category;

    /**
     * @throws CException
     */
    public function run()
    {
        $form = new SearchForm();

        $form->q = $this->query;

        $form->category = $this->category;

        $this->render($this->view, ['searchForm' => $form]);
    }
} 
