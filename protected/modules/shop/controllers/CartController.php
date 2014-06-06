<?php

class CartController extends yupe\components\controllers\FrontController
{
    public function actionIndex()
    {
        $positions = Yii::app()->shoppingCart->positions;
        $this->render('index', array('positions' => $positions));
    }

    public function actionAdd()
    {
        if (Yii::app()->request->isPostRequest)
        {
            if (isset($_POST['Product']['id']))
            {
                $product = Product::model()->findByPk($_POST['Product']['id']);
                if ($product)
                {
                    $variantsId = $_POST['ProductVariant'];
                    $variants   = array();
                    foreach ((array)$variantsId as $var)
                    {
                        if (!$var)
                        {
                            continue;
                        }
                        $variant = ProductVariant::model()->findByPk($var);
                        if ($variant && $variant->product_id == $product->id)
                        {
                            $variants[] = $variant;
                        }
                    }
                    $product->selectedVariants = $variants;
                    Yii::app()->shoppingCart->put($product, $_POST['Product']['quantity'] ? : 1);
                    Yii::app()->ajax->rawText(
                        json_encode(array('result' => 'success', 'message' => 'Товар успешно добавлен в корзину'))
                    );
                }
            }
        }
    }

    public function actionUpdate($id)
    {
        if (Yii::app()->request->isPostRequest)
        {
            $position = Yii::app()->shoppingCart->itemAt($id);
            Yii::app()->shoppingCart->update($position, $_POST['Product']['quantity']);
            Yii::app()->ajax->rawText(
                json_encode(array('result' => 'success', 'message' => 'Количество изменено'))
            );
        }
    }

    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest)
        {
            Yii::app()->shoppingCart->remove($id);
            Yii::app()->ajax->rawText(
                json_encode(array('result' => 'success', 'message' => 'Товар удален из корзины'))
            );
        }
    }

    public function actionClear()
    {
        if (Yii::app()->request->isPostRequest)
        {
            Yii::app()->shoppingCart->clear();
            Yii::app()->ajax->rawText(
                json_encode(array('result' => 'success', 'message' => 'Корзина очищена'))
            );
        }
    }

    public function actionCartWidget()
    {
        $this->widget('application.modules.shop.widgets.ShoppingCartWidget', array('id' => 'shopping-cart-widget'));
    }
}