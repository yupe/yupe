<?php

class CartController extends yupe\components\controllers\FrontController
{
    public function actionIndex()
    {
        $positions = Yii::app()->cart->getPositions();
        $order = new Order(Order::SCENARIO_USER);
        if (!Yii::app()->getUser()->isAuthenticated()) {
            $user = Yii::app()->getUser()->getProfile();
            $order->name = $user->getFullName();
            $order->email = $user->email;
            $order->address = $user->location;
        }
        $couponCodes = Yii::app()->cart->couponManager->coupons;
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
        if (!Yii::app()->getRequest()->getIsPostRequest()) {
            throw new CHttpException(404);
        }

        $product = Yii::app()->getRequest()->getPost('Product');

        if(empty($product) || empty($product['id'])) {
            throw new CHttpException(404);
        }

        $product = CartProduct::model()->findByPk((int)$product['id']);

        if(null === $product) {
            throw new CHttpException(404);
        }

        $variantsId = Yii::app()->getRequest()->getPost('ProductVariant', []);
        $variants = [];
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
        $quantity = isset($product['quantity']) ? (int)$product['quantity'] : 1;
        Yii::app()->cart->put($product, $quantity ? : 1);
        Yii::app()->ajax->rawText(
            json_encode(['result' => 'success', 'message' => Yii::t("CartModule.cart", 'Товар успешно добавлен в корзину')])
        );

    }

    public function actionUpdate($id)
    {
        if (Yii::app()->request->isPostRequest) {
            $position = Yii::app()->cart->itemAt($id);
            Yii::app()->cart->update($position, $_POST['Product']['quantity']);
            Yii::app()->ajax->rawText(
                json_encode(array('result' => 'success', 'message' => Yii::t("CartModule.cart", 'Количество изменено')))
            );
        }
    }

    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            Yii::app()->cart->remove($id);
            Yii::app()->ajax->rawText(
                json_encode(array('result' => 'success', 'message' => Yii::t("CartModule.cart", 'Товар удален из корзины')))
            );
        }
    }

    public function actionClear()
    {
        if (Yii::app()->request->isPostRequest) {
            Yii::app()->cart->clear();
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
        $result = Yii::app()->cart->couponManager->add($code);
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
            Yii::app()->cart->couponManager->remove($code);
            Yii::app()->ajax->success(Yii::t("CartModule.cart", "Купон «{code}» удален", array('{code}' => $code)));
        } else {
            Yii::app()->ajax->failure(Yii::t("CartModule.cart", 'Купон не найден'));
        }
    }

    public function actionClearCoupons()
    {
        Yii::app()->cart->couponManager->clear();
        Yii::app()->ajax->success(Yii::t("CartModule.cart", "Купоны удалены"));
    }

    public function actionCoupons()
    {
        Yii::app()->ajax->success(Yii::app()->cart->couponManager->coupons);
    }
}
