<?php

/**
 * Class ProductRepository
 */
class ProductRepository extends CComponent
{
    protected $attributeFilter;

    public function init()
    {
        $this->attributeFilter = Yii::app()->getComponent('attributesFilter');
    }

    public function getByFilter(array $mainSearchAttributes, array $eavSearchAttributes, $perPage = 20)
    {
        $model = Product::model();

        $criteria = new CDbCriteria();
        $criteria->select = 't.*';
        $criteria->params = [];
        $criteria->addCondition('status = :status');
        $criteria->params['status'] = Product::STATUS_ACTIVE;

        foreach($this->attributeFilter->getMainSearchParams() as $param => $field) {
            if(!empty($mainSearchAttributes[$param])) {
                $criteria->addInCondition($field, $mainSearchAttributes[$param]);
            }
        }

        $eavCriteria = $model->getFilterByEavAttributesCriteria($eavSearchAttributes);

        $criteria->mergeWith($eavCriteria);

        return new CActiveDataProvider(
            $model,
            [
                'criteria' => $criteria,
                'pagination' => [
                    'pageSize' => (int)$perPage,
                    'pageVar' => 'page',
                ],
                'sort' => [
                    'sortVar' => 'sort',
                ],
            ]
        );
    }


    /**
     * @param int $perPage
     * @return CActiveDataProvider
     */
    public function getListForIndexPage($perPage = 20)
    {
        $criteria = new CDbCriteria();
        $criteria->select = 't.*';
        $criteria->params = [];
        $criteria->addCondition('status = :status');
        $criteria->params['status'] = Product::STATUS_ACTIVE;

        return new CActiveDataProvider(
            Product::model(),
            [
                'criteria' => $criteria,
                'pagination' => [
                    'pageSize' => (int)$perPage,
                    'pageVar' => 'page',
                ],
                'sort' => [
                    'sortVar' => 'sort',
                ],
            ]
        );
    }

    /**
     * @param StoreCategory $category
     * @param int $perPage
     * @return CActiveDataProvider
     */
    public function getListForCategory(StoreCategory $category, $perPage = 20)
    {
        $criteria = new CDbCriteria();
        $criteria->select = 't.*';
        $criteria->with = ['categoryRelation' => ['together' => true]];
        $criteria->addCondition('categoryRelation.category_id = :category_id OR t.category_id = :category_id');
        $criteria->addCondition('status = :status');
        $criteria->params = CMap::mergeArray($criteria->params, [':category_id' => $category->id]);
        $criteria->params['status'] = Product::STATUS_ACTIVE;

        return  new CActiveDataProvider(
            Product::model(),
            [
                'criteria' => $criteria,
                'pagination' => [
                    'pageSize' => (int)$perPage,
                    'pageVar' => 'page',
                ],
                'sort' => [
                    'sortVar' => 'sort',
                ],
            ]
        );
    }

    public function search($query, $category = null, $perPage = 20)
    {
        $criteria = new CDbCriteria();
        $criteria->params = [];
        $criteria->addCondition('status = :status');
        $criteria->params['status'] = Product::STATUS_ACTIVE;
        $criteria->addSearchCondition('name', $query, true);

        if ($category) {
            $criteria->addCondition('category_id = :category');
            $criteria->params[':category'] = (int)$category;
        }

        return new CActiveDataProvider(
            Product::model(), [
                'criteria' => $criteria,
                'pagination' => [
                    'pageSize' => (int)$perPage,
                    'pageVar' => 'page',
                ],
                'sort' => [
                    'sortVar' => 'sort',
                ],
            ]
        );
    }

    /**
     * @param $query
     * @return array
     */
    public function searchLite($query)
    {
        $criteria = new CDbCriteria();
        $criteria->params = [];
        $criteria->addCondition('status = :status');
        $criteria->params['status'] = Product::STATUS_ACTIVE;
        $criteria->addSearchCondition('name', $query, true);
        $models = Product::model()->findAll($criteria);
        $result = [];
        foreach ($models as $model) {
            $result[] = CHtml::link($model->name, ['/store/catalog/show', 'name' => $model->slug]);
        }
        return $result;
    }

    /**
     * @param $slug
     * @param array $with
     * @return mixed
     */
    public function getBySlug($slug, array $with = ['producer','type.typeAttributes', 'images', 'mainCategory', 'variants'])
    {
        return Product::model()->published()->with($with)->find('t.slug = :slug', [':slug' => $slug]);
    }
} 
