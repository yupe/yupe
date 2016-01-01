<?php

Yii::import('application.modules.store.components.AttributeFilter');

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
