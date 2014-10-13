<?php
/**
 * Created by PhpStorm.
 * User: coder1
 * Date: 31.05.14
 * Time: 13:08
 */

/**
 * Class CartController
 * Управляет корзиной на сайте
 */
class CartController extends yupe\components\controllers\FrontController
{
    /**
     * @param $id int Good id
     * @throws CHttpException
     */
    public function actionAdd($id)
    {
        Yii::import('catalog.models.Good');
        if (!Good::model()->published()->exists('id = :id', array(':id' => $id))) {
            throw new CHttpException(406, 'Такой продукт не существует');
        }

        // создать корзину если ее нет
        $cart = ShopCart::model()->findByAttributes(array('session_id' => Yii::app()->session->sessionID));
        if (empty($cart)) {
            $cart = new ShopCart();
            $cart->session_id = Yii::app()->session->sessionID;
            $cart->save();
        }

        // добавить в корзину товар
        $cartGood = new ShopCartGood();
        $cartGood->cart_id = $cart->id;
        $cartGood->catalog_good_id = $id;
        // сообщить пользователю о результате
        if ($cartGood->save()) {
            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('ShopModule.shop', 'Product added to your cart successfully. Now you can order it!')
            );
        }

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    /**
     * Удаляем товар из корзины и возвращаемся откуда пришли
     * @param int $id
     * @throws CHttpException Если пытаемся удалить товар, которого нет в корзине
     */
    public function actionDelete($id)
    {
        if (!ShopCartGood::model()->exists('id = :id', array(':id' => $id))) {
            throw new CHttpException(406, 'Такого продукта нет в вашей корзине');
        }
        $cartGood = ShopCartGood::model()->findByPk($id);
        if (!empty($cartGood)) {
            $cartGood->delete();
            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                'Товар удален из вашей корзины'
            );
        }
        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionIndex()
    {
        // создать корзину если ее нет
        $cart = ShopCart::model()->findByAttributes(array('session_id' => Yii::app()->session->sessionID));
        if (empty($cart)) {
            $cart = new ShopCart();
            $cart->session_id = Yii::app()->session->sessionID;
            $cart->save();
        }

        $dataProvider = new CActiveDataProvider('ShopCartGood', array(
            'criteria' => array(
                'condition' => 'cart_id=:cart_id',
                'params' => array(
                    ':cart_id' => $cart->id
                )
            ),
            'countCriteria' => array(
                'condition' => 'cart_id=:cart_id',
                'params' => array(
                    ':cart_id' => $cart->id
                )
            ),
            'pagination' => array(
                'pageSize' => 20,
            ),
        ));
        $this->render('index', array('dataProvider' => $dataProvider, 'cart' => $cart));
    }

    public function actionMultiaction()
    {
        if (!Yii::app()->getRequest()->getIsAjaxRequest() || !Yii::app()->getRequest()->getIsPostRequest()) {
            throw new CHttpException(404);
        }

        $model = Yii::app()->getRequest()->getPost('model');
        $action = Yii::app()->getRequest()->getPost('do');

        if (!isset($model, $action)) {
            throw new CHttpException(404);
        }

        $items = Yii::app()->getRequest()->getPost('items');

        if (!is_array($items) || empty($items)) {
            Yii::app()->ajax->success();
        }

        $transaction = Yii::app()->db->beginTransaction();

        try {
            switch ($action) {
                case \yupe\components\controllers\BackController::BULK_DELETE:
                    $class = CActiveRecord::model($model);
                    $criteria = new CDbCriteria;
                    $items = array_filter($items, 'intval');
                    $criteria->addInCondition('id', $items);
                    $count = $class->deleteAll($criteria);
                    $transaction->commit();
                    Yii::app()->ajax->success(
                        Yii::t(
                            'YupeModule.yupe', 'Removed {count} records!', array(
                                '{count}' => $count
                            )
                        )
                    );
                    break;

                default:
                    throw new CHttpException(404);
                    break;
            }

        } catch (Exception $e) {
            $transaction->rollback();
            Yii::log($e->__toString(), CLogger::LEVEL_ERROR);
            Yii::app()->ajax->failure($e->getMessage());
        }
    }
}