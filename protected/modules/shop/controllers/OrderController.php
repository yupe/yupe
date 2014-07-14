<?php

/**
 * Created by PhpStorm.
 * User: coder1
 * Date: 31.05.14
 * Time: 15:43
 */
class OrderController extends \yupe\components\controllers\FrontController
{
    public function actionCreate($id)
    {
        $cart = ShopCart::model()->findByPk($id);
        // если корзина не существует - значит плохой запрос
        // если корзина пустая то сообщить что нечего оформлять
        if (empty($cart) || count($cart->shopCartGoods) === 0) {
            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                Yii::t('ShopModule.shop', 'Your cart is empty')
            );
            $this->redirect('/shop/cart/index');
        }

        $order = new ShopOrder();
        $order->price = $cart->sum;

        if ($aPost = Yii::app()->request->getPost('ShopOrder')) {
            // создаем заказ
            $order->attributes = $aPost;
            if ($order->save()) {
                // Поместить в заказ продукты
                foreach ($cart->shopCartGoods as $cartGood) {
                    /**
                     * @var ShopCartGood $cartGood
                     */
                    $order->addGood($cartGood->catalogGood);
                }
                // очистить корзину
                $cart->delete();
                // отправляем лог о том, что он создался
                /**
                 * @var YMailMessage $mailMessage
                 */
                Yii::app()->getModule('mail');
                $mailMessage = Yii::app()->mailMessage;
                $mailMessage->raiseMailEvent('new-order', array('orderId' => $order->id));
                Yii::log('Создан новый заказ ' . $order->id, CLogger::LEVEL_INFO, 'shop.order.create');
                // сообщить пользователю, что заказ создан
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('ShopModule.shop', 'Your order created. Our manager will contact you soon. Thank you for purchase!')
                );
                // отправляем в магазин
                $this->redirect('/shop');
            }
        }

        $this->render('create', array('cart' => $cart, 'order' => $order));

    }
} 