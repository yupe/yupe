<?php
use yupe\components\controllers\FrontController;

class CategoryController extends FrontController
{
    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @var AttributeFilter
     */
    protected $attributeFilter;

    public function init()
    {
        $this->productRepository = Yii::app()->getComponent('productRepository');
        $this->attributeFilter = Yii::app()->getComponent('attributesFilter');

        parent::init();
    }

    public function actionIndex()
    {
        $this->render(
            'index',
            [
                'dataProvider' => new CArrayDataProvider(
                    StoreCategory::model()->published()->getMenuList(1), [
                        'id' => 'id',
                        'pagination' => false,
                    ]
                ),
            ]
        );
    }

    /**
     * @param $path
     * @throws CHttpException
     */
    public function actionView($path)
    {
        $category = StoreCategory::model()->findByPath($path);

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
            'view',
            [
                'dataProvider' => $data,
                'category' => $category,
            ]
        );
    }
}