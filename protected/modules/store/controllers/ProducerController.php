<?php
use yupe\components\controllers\FrontController;

class ProducerController extends FrontController
{
    public function actionIndex()
    {
        $this->render('index', [
            'brands' => Producer::model()->getAllDataProvider()
        ]);
    }

    public function actionView($slug)
    {
        $producer = Producer::model()->getBySlug($slug);

        if (!$producer) {
            throw new CHttpException(404, Yii::t('StoreModule.store', 'Page was not found!'));
        }

        $productRepository = Yii::app()->getComponent('productRepository');

        $this->render('view', [
            'brand' => $producer,
            'products' => $productRepository->getByBrandProvider($producer)
        ]);
    }
}
