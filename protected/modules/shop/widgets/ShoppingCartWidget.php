<?php

Yii::import('application.modules.shop.models.*');

class ShoppingCartWidget extends yupe\widgets\YWidget
{
    /**
     * @var string Id of elements
     */
    public $id;

    public $layout = 'main';

    public function init()
    {

    }

    public function run()
    {
        $this->render($this->layout ? : 'application.modules.shop.views.widgets.ShoppingCartWidget', array('id' => $this->id));
    }
}