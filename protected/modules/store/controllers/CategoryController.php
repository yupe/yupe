<?php
use yupe\components\controllers\FrontController;

/**
 * Class CategoryController
 */
class CategoryController extends FrontController
{
    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @var StoreCategoryRepository
     */
    protected $categoryRepository;

    /**
     * @var AttributeFilter
     */
    protected $attributeFilter;

    /**
     *
     */
    public function init()
    {
        parent::init();
        $this->productRepository = Yii::app()->getComponent('productRepository');
        $this->attributeFilter = Yii::app()->getComponent('attributesFilter');
        $this->categoryRepository = Yii::app()->getComponent('categoryRepository');
    }

    /**
     *
     */
    public function actionIndex()
    {
        $this->render(
            'index',
            [
                'dataProvider' => $this->categoryRepository->getAllDataProvider(),
            ]
        );
    }

    /**
     * @param $path
     * @throws CHttpException
     */
    public function actionView($path)
    {
        $category = $this->categoryRepository->getByPath($path);

        if (null === $category) {
            throw new CHttpException(404);
        }

        $data = Yii::app()->getRequest()->getQueryString() ? $this->productRepository->getByFilter(
            $this->attributeFilter->getMainAttributesForSearchFromQuery(
                Yii::app()->getRequest(),
                [AttributeFilter::MAIN_SEARCH_PARAM_CATEGORY => [$category->id]]
            ),
            $this->attributeFilter->getTypeAttributesForSearchFromQuery(Yii::app()->getRequest())
        ) : $this->productRepository->getListForCategory($category);

        $this->render(
            $category->view ?: 'view',
            [
                'dataProvider' => $data,
                'category' => $category,
            ]
        );
    }
}