<?php

/**
 * Class ProductRepository
 */
class ProductRepository extends CComponent
{
    /**
     * @param int $perPage
     * @return CActiveDataProvider
     */
    public function getListForIndexPage($perPage = 20)
    {
        $criteria = new CDbCriteria();
        $criteria->params = [];
        $criteria->addCondition('status = :status');
        $criteria->params['status'] = Product::STATUS_ACTIVE;

        return $dataProvider = new CActiveDataProvider(
            Product::model(), array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => (int)$perPage,
                    'pageVar' => 'page',
                ),
                'sort' => array(
                    'sortVar' => 'sort',
                ),
            )
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

        $criteria->with = ['categoryRelation' => ['together' => true]];
        $criteria->addCondition('categoryRelation.category_id = :category_id OR t.category_id = :category_id');
        $criteria->addCondition('status = :status');
        $criteria->params = CMap::mergeArray($criteria->params, [':category_id' => $category->id]);
        $criteria->params['status'] = Product::STATUS_ACTIVE;

        return $dataProvider = new CActiveDataProvider(
            Product::model(), array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => (int)$perPage,
                    'pageVar' => 'page',
                ),
                'sort' => array(
                    'sortVar' => 'sort',
                ),
            )
        );
    }

    public function search($query, $category = null, $perPage = 20)
    {
        $criteria = new CDbCriteria();
        $criteria->params = [];
        $criteria->addCondition('status = :status');
        $criteria->params['status'] = Product::STATUS_ACTIVE;
        $criteria->addSearchCondition('name', $query, true);

        if(null !== $category) {
            $criteria->addCondition('category_id = :category');
            $criteria->params[':category'] = (int)$category;
        }

        return $dataProvider = new CActiveDataProvider(
            Product::model(), array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => (int)$perPage,
                    'pageVar' => 'page',
                ),
                'sort' => array(
                    'sortVar' => 'sort',
                ),
            )
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
            $result[] = CHtml::link($model->name, ['/store/catalog/show', 'name' => $model->alias]);
        }
        return $result;
    }

    /**
     * @param $alias
     * @return mixed
     */
    public function getByAlias($alias)
    {
        return Product::model()->published()->find('alias = :alias', [':alias' => $alias]);
    }
} 
