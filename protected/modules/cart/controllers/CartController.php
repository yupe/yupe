<?php

class CartController extends yupe\components\controllers\FrontController
{
    public function actionIndex()
    {
        $positions = Yii::app()->shoppingCart->positions;
        $order = new Order(Order::SCENARIO_USER);
        if (!Yii::app()->user->isGuest) {
            $user = Yii::app()->getUser()->getProfile();
            $order->name = $user->last_name . ' ' . $user->first_name;
            $order->email = $user->email;
            //$order->phone   = $user->phone;
            //$order->city    = $user->city;
            $order->address = $user->location;
        }
        $couponCodes = Yii::app()->shoppingCart->couponManager->coupons;
        $coupons = array();
        if (Yii::app()->hasModule('coupon')) {
            foreach ($couponCodes as $code) {
                $coupons[] = Coupon::model()->getCouponByCode($code);
            }
        }
        $this->render('index', array('positions' => $positions, 'order' => $order, 'coupons' => $coupons));
    }

    public function actionAdd()
    {
        if (Yii::app()->request->isPostRequest) {
            if (isset($_POST['Product']['id'])) {
                $product = CartProduct::model()->findByPk($_POST['Product']['id']);
                if ($product) {
                    $variantsId = $_POST['ProductVariant'];
                    $variants = array();
                    foreach ((array)$variantsId as $var) {
                        if (!$var) {
                            continue;
                        }
                        $variant = ProductVariant::model()->findByPk($var);
                        if ($variant && $variant->product_id == $product->id) {
                            $variants[] = $variant;
                        }
                    }
                    $product->selectedVariants = $variants;
                    Yii::app()->shoppingCart->put($product, $_POST['Product']['quantity'] ?: 1);
                    Yii::app()->ajax->rawText(
                        json_encode(array('result' => 'success', 'message' => Yii::t("CartModule.cart", 'Товар успешно добавлен в корзину')))
                    );
                }
            }
        }
    }

    public function actionUpdate($id)
    {
        if (Yii::app()->request->isPostRequest) {
            $position = Yii::app()->shoppingCart->itemAt($id);
            Yii::app()->shoppingCart->update($position, $_POST['Product']['quantity']);
            Yii::app()->ajax->rawText(
                json_encode(array('result' => 'success', 'message' => Yii::t("CartModule.cart", 'Количество изменено')))
            );
        }
    }

    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            Yii::app()->shoppingCart->remove($id);
            Yii::app()->ajax->rawText(
                json_encode(array('result' => 'success', 'message' => Yii::t("CartModule.cart", 'Товар удален из корзины')))
            );
        }
    }

    public function actionClear()
    {
        if (Yii::app()->request->isPostRequest) {
            Yii::app()->shoppingCart->clear();
            Yii::app()->ajax->rawText(
                json_encode(array('result' => 'success', 'message' => Yii::t("CartModule.cart", 'Корзина очищена')))
            );
        }
    }

    public function actionCartWidget()
    {
        //$this->renderPartial('//cart/widgets/views/shoppingCart');
        // хочет отправить куки новые для авторизации каждый раз
        $this->widget('cart.widgets.ShoppingCartWidget', array('id' => 'shopping-cart-widget'));
    }

    public function actionAddCoupon()
    {
        $code = strtoupper(Yii::app()->request->getParam('code'));;
        $result = Yii::app()->shoppingCart->couponManager->add($code);
        if (true === $result) {
            Yii::app()->ajax->success(Yii::t("CartModule.cart", "Купон «{code}» добавлен", array('{code}' => $code)));
        } else {
            Yii::app()->ajax->failure($result);
        }
    }

    public function actionRemoveCoupon()
    {
        $code = strtoupper(Yii::app()->request->getParam('code'));
        if ($code) {
            Yii::app()->shoppingCart->couponManager->remove($code);
            Yii::app()->ajax->success(Yii::t("CartModule.cart", "Купон «{code}» удален", array('{code}' => $code)));
        } else {
            Yii::app()->ajax->failure(Yii::t("CartModule.cart", 'Купон не найден'));
        }
    }

    public function actionClearCoupons()
    {
        Yii::app()->shoppingCart->couponManager->clear();
        Yii::app()->ajax->success(Yii::t("CartModule.cart", "Купоны удалены"));
    }

    public function actionCoupons()
    {
        Yii::app()->ajax->success(Yii::app()->shoppingCart->couponManager->coupons);
    }
}
