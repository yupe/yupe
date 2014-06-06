<?php

Yii::import('application.modules.shop.models.*');

class ShoppingCartWidget extends yupe\widgets\YWidget
{
    /**
     * @var string Id of elements
     */
    public $id;

    public $view = 'application.modules.shop.views.widgets.ShoppingCartWidget';

    public function init()
    {

    }

    public function run()
    {
        $this->render($this->view, array('id' => $this->id));
    }
}