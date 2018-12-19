<?php

use yupe\components\controllers\FrontController;

/**
 * Class CartController
 */
class CartController extends FrontController
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
            $order->setAttributes([
                'name' => $user->getFullName(),
                'email' => $user->email,
                'city' => $user->location,
            ]);
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

        /* @var IECartPosition $model */
        $model = CartProduct::model()->published()->findByPk((int)$product['id']);

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

        try {
            Yii::app()->cart->put($model, $quantity);
            Yii::app()->ajax->success(Yii::t("CartModule.cart", 'Product successfully added to your basket'));
        } catch (Exception $exception) {
            Yii::app()->ajax->failure($exception->getMessage());
        }
    }

    /**
     * @throws CHttpException
     */
    public function actionUpdate()
    {
        if (!Yii::app()->getRequest()->getIsPostRequest() || !Yii::app()->getRequest()->getPost('id')) {
            throw new CHttpException(404);
        }

        /* @var IECartPosition $position */
        $position = Yii::app()->cart->itemAt(Yii::app()->getRequest()->getPost('id'));
        $quantity = (int)Yii::app()->getRequest()->getPost('quantity');

        try {
            Yii::app()->cart->update($position, $quantity);
            Yii::app()->ajax->success(Yii::t("CartModule.cart", 'Quantity changed'));
        } catch (Exception $exception) {
            Yii::app()->ajax->failure($exception->getMessage());
        }
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
        $this->widget('cart.widgets.ShoppingCartWidget', ['id' => 'shopping-cart-widget']);
    }
}
