<?php

class ShoppingCartWidget extends yupe\widgets\YWidget
{
    /**
     * @var string Id of elements
     */
    public $id;

    public $view = 'shoppingCart';

    public function init()
    {
        Yii::import('application.modules.store.models.*');
        Yii::import('application.modules.cart.CartModule');
    }

    public function run()
    {
        $this->render($this->view, [ 'id' => $this->id ]);
    }
}
