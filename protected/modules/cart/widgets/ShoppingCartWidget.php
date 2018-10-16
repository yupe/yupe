<?php

Yii::import('application.modules.store.models.*');
Yii::import('application.modules.cart.CartModule');

/**
 * Class ShoppingCartWidget
 */
class ShoppingCartWidget extends yupe\widgets\YWidget
{
    /**
     * @var string Id of elements
     */
    public $id;

    /**
     * @var string
     */
    public $view = 'shoppingCart';

    /**
     * @throws CException
     */
    public function run()
    {
        $this->render($this->view, ['id' => $this->id]);
    }
}
