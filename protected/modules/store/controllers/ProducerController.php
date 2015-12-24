<?php
use yupe\components\controllers\FrontController;

class ProducerController extends FrontController
{
    /**
     * @var ProductRepository
     */
    protected $productRepository;

    public function init()
    {
        $this->productRepository = Yii::app()->getComponent('productRepository');

        parent::init();
    }

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
            throw new CHttpException(404, Yii::t('StoreModule.store', 'Page not found!'));
        }

        $this->render('view', [
            'brand' => $producer,
            'products' => $this->productRepository->getByBrandProvider($producer)
        ]);
    }
}
