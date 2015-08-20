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

    public function getByFilter(array $mainSearchAttributes, array $eavSearchAttributes)
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

        if(!empty($mainSearchAttributes[AttributeFilter::MAIN_SEARCH_PARAM_NAME])) {
            $criteria->addSearchCondition('name', $mainSearchAttributes[AttributeFilter::MAIN_SEARCH_PARAM_NAME], true);
        }

        $eavCriteria = $model->getFilterByEavAttributesCriteria($eavSearchAttributes);

        $criteria->mergeWith($eavCriteria);

        return new CActiveDataProvider(
            $model,
            [
                'criteria' => $criteria,
                'pagination' => [
                    'pageSize' => (int)Yii::app()->getModule('store')->itemsPerPage,
                    'pageVar' => 'page',
                ],
                'sort' => [
                    'sortVar' => 'sort',
                    'defaultOrder' => 't.position'
                ],
            ]
        );
    }


    /**
     * @return CActiveDataProvider
     */
    public function getListForIndexPage()
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
                    'pageSize' => (int)Yii::app()->getModule('store')->itemsPerPage,
                    'pageVar' => 'page',
                ],
                'sort' => [
                    'sortVar' => 'sort',
                    'defaultOrder' => 't.position'
                ],
            ]
        );
    }

    /**
     * @param StoreCategory $category
     * @return CActiveDataProvider
     */
    public function getListForCategory(StoreCategory $category)
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
                    'pageSize' => (int)Yii::app()->getModule('store')->itemsPerPage,
                    'pageVar' => 'page',
                ],
                'sort' => [
                    'sortVar' => 'sort',
                    'defaultOrder' => 't.position'
                ],
            ]
        );
    }

    /**
     * @param $query
     * @return array
     */
    public function search($query)
    {
        $criteria = new CDbCriteria();
        $criteria->params = [];
        $criteria->addCondition('status = :status');
        $criteria->params['status'] = Product::STATUS_ACTIVE;
        $criteria->addSearchCondition('name', $query, true);
        return Product::model()->findAll($criteria);
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
