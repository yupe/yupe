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
     * @param string $name Product slug
     * @param string $category Product category path
     * @throws CHttpException
     */
    public function actionView($name, $category = null)
    {
        $product = $this->productRepository->getBySlug(
            $name,
            [
                'type.typeAttributes',
                'category',
                'variants',
                'attributesValues',
            ]
        );

        if (
            null === $product ||
            (isset($product->category) && $product->category->path !== $category) ||
            (!isset($product->category) && !is_null($category))
        ) {
            throw new CHttpException(404, Yii::t('StoreModule.catalog', 'Product was not found!'));
        }

        Yii::app()->eventManager->fire(StoreEvents::PRODUCT_OPEN, new ProductOpenEvent($product));

        $this->render($product->view ?:'view', ['product' => $product]);
    }
}