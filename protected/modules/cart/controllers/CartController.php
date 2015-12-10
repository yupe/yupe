<?php

/**
 * Class CartController
 */
class CartController extends \yupe\components\controllers\FrontController
{
    /**
     *
     */
    public function actionIndex()
    {
        $positions = Yii::app()->cart->getPositions();
        $order = new Order(Order::SCENARIO_USER);
        if (Yii::app()->getUser()->isAuthenticated()) {
            $user = Yii::app()->getUser()->getProfile();
            $order->name = $user->getFullName();
            $order->email = $user->email;
            $order->city = $user->location;
        }

        $coupons = [];

        if (Yii::app()->hasModule('coupon')) {

            $couponCodes = Yii::app()->cart->couponManager->coupons;

            foreach ($couponCodes as $code) {
                $coupons[] = Coupon::model()->getCouponByCode($code);
            }
        }

        $deliveryTypes = Delivery::model()->published()->findAll();

        $this->render(
            'index',
            ['positions' => $positions, 'order' => $order, 'coupons' => $coupons, 'deliveryTypes' => $deliveryTypes]
        );
    }

    /**
     * @throws CHttpException
     */
    public function actionAdd()
    {
        if (!Yii::app()->getRequest()->getIsPostRequest()) {
            throw new CHttpException(404);
        }

        $product = Yii::app()->getRequest()->getPost('Product');

        if (empty($product['id'])) {
            throw new CHttpException(404);
        }

        $model = CartProduct::model()->findByPk((int)$product['id']);

        if (null === $model) {
            throw new CHttpException(404);
        }

        $variantsId = Yii::app()->getRequest()->getPost('ProductVariant', []);
        $variants = [];
        foreach ((array)$variantsId as $var) {
            if (!$var) {
                continue;
            }
            $variant = ProductVariant::model()->findByPk($var);
            if ($variant && $variant->product_id == $model->id) {
                $variants[] = $variant;
            }
        }
        $model->selectedVariants = $variants;
        $quantity = empty($product['quantity']) ? 1 : (int)$product['quantity'];
        Yii::app()->cart->put($model, $quantity);
        Yii::app()->ajax->success(Yii::t("CartModule.cart", 'Product successfully added to your basket'));
    }

    /**
     * @throws CHttpException
     */
    public function actionUpdate()
    {
        if (!Yii::app()->getRequest()->getIsPostRequest() || !Yii::app()->getRequest()->getPost('id')) {
            throw new CHttpException(404);
        }

        $position = Yii::app()->cart->itemAt(Yii::app()->getRequest()->getPost('id'));
        $quantity = (int)Yii::app()->getRequest()->getPost('quantity');
        Yii::app()->cart->update($position, $quantity);
        Yii::app()->ajax->success(Yii::t("CartModule.cart", 'Quantity changed'));
    }

    /**
     * @throws CHttpException
     */
    public function actionDelete()
    {
        if (!Yii::app()->getRequest()->getIsPostRequest() || !Yii::app()->getRequest()->getPost('id')) {
            throw new CHttpException(404);
        }

        Yii::app()->cart->remove(Yii::app()->getRequest()->getPost('id'));
        Yii::app()->ajax->success(Yii::t("CartModule.cart", 'Product removed from cart'));
    }

    /**
     * @throws CHttpException
     */
    public function actionClear()
    {
        if (!Yii::app()->getRequest()->getIsPostRequest()) {
            throw new CHttpException(404);
        }

        Yii::app()->cart->clear();
        Yii::app()->ajax->success(Yii::t("CartModule.cart", 'Cart is cleared'));
    }

    /**
     *
     */
    public function actionWidget()
    {
        //$this->renderPartial('//cart/widgets/views/shoppingCart');
        // хочет отправить куки новые для авторизации каждый раз
        $this->widget('cart.widgets.ShoppingCartWidget', ['id' => 'shopping-cart-widget']);
    }

}
