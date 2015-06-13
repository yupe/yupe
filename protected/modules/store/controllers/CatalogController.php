<?php

/**
 * Class CatalogController
 * @property ProductRepository $productRepository
 *
 */
class CatalogController extends \yupe\components\controllers\FrontController
{
    /**
     *
     * @var
     */
    protected $productRepository;

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
     * @param $name
     * @throws CHttpException
     */
    public function actionShow($name)
    {
        $product = $this->productRepository->getBySlug($name);

        if (null === $product) {
            throw new CHttpException(404, Yii::t('StoreModule.catalog', 'Product was not found!'));
        }

        $this->render('product', ['product' => $product]);
    }

    /**
     *
     */
    public function actionIndex()
    {
        $data = Yii::app()->getRequest()->getQueryString() ? $this->productRepository->getByFilter(
            $this->attributeFilter->getMainAttributesForSearchFromQuery(Yii::app()->getRequest()),
            $this->attributeFilter->getEavAttributesForSearchFromQuery(Yii::app()->getRequest())
        ) : $this->productRepository->getListForIndexPage();

        $this->render('index', ['dataProvider' => $data]);
    }

    /**
     * @param $path
     * @throws CHttpException
     */
    public function actionCategory($path)
    {
        $category = StoreCategory::model()->findByPath($path);

        if (null === $category) {
            throw new CHttpException(404);
        }

        $data = Yii::app()->getRequest()->getQueryString() ? $this->productRepository->getByFilter(
            $this->attributeFilter->getMainAttributesForSearchFromQuery(Yii::app()->getRequest(), [AttributeFilter::MAIN_SEARCH_PARAM_CATEGORY => [$category->id]]),
            $this->attributeFilter->getEavAttributesForSearchFromQuery(Yii::app()->getRequest())
        ) : $this->productRepository->getListForCategory($category);


        $this->render(
            'category',
            [
                'dataProvider' => $data,
                'category' => $category
            ]
        );
    }

    public function actionSearch()
    {
        if (!Yii::app()->getRequest()->getQuery('SearchForm')) {
            throw new CHttpException(404);
        }

        $form = new SearchForm();

        $form->setAttributes(Yii::app()->getRequest()->getQuery('SearchForm'));

        if ($form->validate()) {

            $category = $form->category ? StoreCategory::model()->findByPk($form->category) : null;

            $this->render(
                'search',
                [
                    'category' => $category,
                    'searchForm' => $form,
                    'dataProvider' => $this->productRepository->getByFilter(
                            $this->attributeFilter->getMainAttributesForSearchFromQuery(Yii::app()->getRequest(), [AttributeFilter::MAIN_SEARCH_PARAM_NAME => $form->q]),
                            $this->attributeFilter->getEavAttributesForSearchFromQuery(Yii::app()->getRequest())
                        )
                ]
            );
        }
    }

    /**
     *
     */
    public function actionAutocomplete()
    {
        $query = Yii::app()->getRequest()->getQuery('term');

        $result = [];

        if (strlen($query) > 2) {
            $result = $this->productRepository->search($query);
        }

        Yii::app()->ajax->raw($result);
    }
}
