<?php

class ProductRepository extends CComponent
{
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

    public function searchLite($query)
    {
        $criteria = new CDbCriteria();
        $criteria->params = [];
        $criteria->addCondition('status = :status');
        $criteria->params['status'] = Product::STATUS_ACTIVE;
        $criteria->addSearchCondition('name', $query, true);
        $models = Product::model()->findAll($criteria);
        $result = [];
        foreach($models as $model) {
            $result[] = CHtml::link($model->name, ['/store/catalog/show', 'name' => $model->alias]);
        }
        return $result;
    }
} 