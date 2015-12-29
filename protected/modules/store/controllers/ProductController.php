<?php

use yupe\components\controllers\FrontController;

/**
 * Class ProductController
 */
class ProductController extends FrontController
{
    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @var AttributeFilter
     */
    protected $attributeFilter;

    /**
     *
     */
    public function init()
    {
        $this->productRepository = Yii::app()->getComponent('productRepository');
        $this->attributeFilter = Yii::app()->getComponent('attributesFilter');

        parent::init();
    }

    /**
     *
     */
    public function actionIndex()
    {
        $typesSearchParam = $this->attributeFilter->getTypeAttributesForSearchFromQuery(Yii::app()->getRequest());

        $mainSearchParam = $this->attributeFilter->getMainAttributesForSearchFromQuery(
            Yii::app()->getRequest(),
            [
                AttributeFilter::MAIN_SEARCH_PARAM_NAME => Yii::app()->getRequest()->getQuery(AttributeFilter::MAIN_SEARCH_QUERY_NAME)
            ]
        );

        if (!empty($mainSearchParam) || !empty($typesSearchParam)) {
            $data = $this->productRepository->getByFilter($mainSearchParam, $typesSearchParam);
        } else {
            $data = $this->productRepository->getListForIndexPage();
        }

        $this->render(
            'index',
            [
                'dataProvider' => $data,
            ]
        );
    }

    /**
     * @param $name
     * @throws CHttpException
     */
    public function actionView($name)
    {
        $product = $this->productRepository->getBySlug($name);

        if (null === $product) {
            throw new CHttpException(404, Yii::t('StoreModule.catalog', 'Product was not found!'));
        }

        $this->render('view', ['product' => $product]);
    }
}