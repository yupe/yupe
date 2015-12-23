<?php
Yii::import('application.modules.store.models.Product');

/**
 * Class ProductsFromCategoryWidget
 *
 * Show products from specified category
 *
 * @property string $slug Products category slug
 * @property bool|integer $limit The number of products. Default: false (unlimited)
 * @property string $order The order of products. Default: id DESC
 * @property string $view Widget view file
 */
class ProductsFromCategoryWidget extends \yupe\widgets\YWidget
{
    /**
     * @var
     */
    public $slug;
    /**
     * @var bool
     */
    public $limit = false;
    /**
     * @var string
     */
    public $order = 't.id DESC';
    /**
     * @var string
     */
    public $view = 'default';

    /**
     * @var StoreCategoryRepository $categoryRepository
     */
    protected $categoryRepository;

    /**
     * @var ProductRepository $productRepository
     */
    protected $productRepository;

    /**
     *
     */
    public function init()
    {
        $this->categoryRepository = Yii::app()->getComponent('categoryRepository');
        $this->productRepository = Yii::app()->getComponent('productRepository');
        parent::init();
    }

    /**
     * @return bool
     * @throws CException
     */
    public function run()
    {
        $category = $this->categoryRepository->getByAlias($this->slug);

        if (null === $category) {
            return false;
        }

        $this->render(
            $this->view,
            [
                'category' => $category,
                'products' => $this->productRepository->getListForCategory($category, $this->limit),
            ]
        );
    }
}