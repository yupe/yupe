<?php

Yii::import('application.modules.store.forms.SearchForm');

class SearchProductWidget extends \yupe\widgets\YWidget
{
    public $view = 'search-product-form';

    public $query;

    public $category;

    public function run()
    {
        $form = new SearchForm();

        $form->q = $this->query;

        $form->category = $this->category;

        $this->render($this->view, ['searchForm' => $form]);
    }
} 
