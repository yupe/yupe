<?php
use yupe\components\controllers\FrontController;

/**
 * Class ProducerController
 */
class ProducerController extends FrontController
{
    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @var ProducerRepository
     */
    protected $producerRepository;

    /**
     *
     */
    public function init()
    {
        $this->productRepository = Yii::app()->getComponent('productRepository');

        $this->producerRepository = Yii::app()->getComponent('producerRepository');

        parent::init();
    }

    /**
     *
     */
    public function actionIndex()
    {
        $this->render(
            'index',
            [
                'brands' => $this->producerRepository->getAllDataProvider(),
            ]
        );
    }

    /**
     * @param $slug
     * @throws CHttpException
     */
    public function actionView($slug)
    {
        $producer = $this->producerRepository->getBySlug($slug);

        if (null === $producer) {
            throw new CHttpException(404, Yii::t('StoreModule.store', 'Page not found!'));
        }

        $this->render(
            $producer->view ?: 'view',
            [
                'brand' => $producer,
                'products' => $this->productRepository->getByBrandProvider($producer),
            ]
        );
    }
}
