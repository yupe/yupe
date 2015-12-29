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
     * @throws CException
     */
    public function run()
    {
        $this->render($this->view);
    }
} 
