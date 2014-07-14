<?php
/**
 * Created by PhpStorm.
 * User: coder1
 * Date: 31.05.14
 * Time: 12:47
 */

/**
 * Виджет корзины:
 *
 * @category YupeWidgets
 * @package  yupe.modules.shop.widgets
 * @author   Yupe Team <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     http://yupe.ru
 *
 **/
class CartWidget extends yupe\widgets\YWidget
{
    public function run()
    {
        // создать корзину если ее нет
        $cart = ShopCart::model()->findByAttributes(array('session_id' => Yii::app()->session->sessionID));
        if (empty($cart)) {
            $cart = new ShopCart();
            $cart->session_id = Yii::app()->session->sessionID;
            $cart->save();
        }

        $this->render('cart', array('cart' => $cart));
    }
} 