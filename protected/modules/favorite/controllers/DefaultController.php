<?php

use yupe\components\controllers\FrontController;

/**
 * Class DefaultController
 */
class DefaultController extends FrontController
{
    /**
     * @var FavoriteService
     *
     */

    protected $favorite;

    /**
     * @var ProductRepository
     */
    protected $productRepository;


    /**
     *
     */
    public function init()
    {
        $this->favorite = Yii::app()->getComponent('favorite');

        $this->productRepository = Yii::app()->getComponent('productRepository');

        parent::init();
    }

    /**
     * @throws CHttpException
     */
    public function actionAdd()
    {
        if (!Yii::app()->getRequest()->getIsPostRequest() || !Yii::app()->getRequest()->getIsAjaxRequest()) {
            throw new CHttpException(404);
        }

        $productId = (int)Yii::app()->getRequest()->getPost('id');

        if (!$productId) {
            throw new CHttpException(404);
        }

        if ($this->favorite->add($productId)) {
            Yii::app()->ajax->raw(
                [
                    'result' => true,
                    'data' => Yii::t('FavoriteModule.favorite', 'Success added!'),
                    'count' => $this->favorite->count(),
                ]
            );
        }

        Yii::app()->ajax->raw(
            [
                'message' => Yii::t('FavoriteModule.favorite', 'Error =('),
                'result' => false,
                'count' => $this->favorite->count(),
            ]
        );
    }

    /**
     * @throws CHttpException
     */
    public function actionRemove()
    {
        if (!Yii::app()->getRequest()->getIsPostRequest() || !Yii::app()->getRequest()->getIsAjaxRequest()) {
            throw new CHttpException(404);
        }

        $productId = (int)Yii::app()->getRequest()->getPost('id');

        if (!$productId) {
            throw new CHttpException(404);
        }

        if ($this->favorite->remove($productId)) {
            Yii::app()->ajax->raw(
                [
                    'result' => true,
                    'data' => Yii::t('FavoriteModule.favorite', 'Success removed!'),
                    'count' => $this->favorite->count(),
                ]
            );
        }

        Yii::app()->ajax->raw(
            [
                'message' => Yii::t('FavoriteModule.favorite', 'Error =('),
                'result' => false,
                'count' => $this->favorite->count(),
            ]
        );
    }

    /**
     *
     */
    public function actionIndex()
    {
        $this->render('index', ['dataProvider' => $this->favorite->products()]);
    }
}