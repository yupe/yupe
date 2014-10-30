<?php

/**
 * Class CatalogController
 * @property ProductRepository $productRepository
 *
 */
class CatalogController extends yupe\components\controllers\FrontController
{
    /**
     *
     * @var
     */
    protected $productRepository;

    /**
     *
     */
    public function init()
    {
        $this->productRepository = new ProductRepository();

        parent::init();
    }

    /**
     * @param $name
     * @throws CHttpException
     */
    public function actionShow($name)
    {
        $product = $this->productRepository->getByAlias($name);

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
        $this->render('index', ['dataProvider' => $this->productRepository->getListForIndexPage()]);
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

        $this->render(
            'category',
            [
                'dataProvider' => $this->productRepository->getListForCategory($category),
                'category' => $category
            ]
        );
    }

    public function actionSearch()
    {
        if (Yii::app()->getRequest()->getQuery('SearchForm')) {

            $form = new SearchForm();

            $form->setAttributes(Yii::app()->getRequest()->getQuery('SearchForm'));

            if ($form->validate()) {

                $category = $form->category ? StoreCategory::model()->findByPk($form->category) : null;

                $this->render(
                    'search',
                    [
                        'category'   => $category,
                        'searchForm' => $form,
                        'dataProvider' => $this->productRepository->search($form->q, $form->category)
                    ]
                );

            }
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
            $result = $this->productRepository->searchLite($query);
        }

        Yii::app()->ajax->raw($result);
    }
}
