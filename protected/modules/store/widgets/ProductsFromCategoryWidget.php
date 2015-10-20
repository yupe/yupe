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
    public $slug;
    public $limit = false;
    public $order = 't.id DESC';
    public $view = 'default';

    public function run()
    {
        $category = StoreCategory::model()->getByAlias($this->slug);

        if(!$category) {
            return false;
        }

        $criteria = new CDbCriteria();
        $criteria->select = 't.*';
        $criteria->with = ['categoryRelation' => ['together' => true]];
        $criteria->addCondition('categoryRelation.category_id = :category_id OR t.category_id = :category_id');
        $criteria->addCondition('status = :status');
        if ($this->limit) {
            $criteria->limit = $this->limit;
        }
        $criteria->order = $this->order;
        $criteria->group = 't.id';
        $criteria->params = [
            ':category_id' => $category->id,
            ':status' => Product::STATUS_ACTIVE
        ];

        $this->render($this->view, [
            'category' => $category,
            'products' => Product::model()->findAll($criteria)
        ]);
    }
}