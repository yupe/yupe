<?php

/**
 * Class ProductRepository
 */
class ProductRepository extends CApplicationComponent
{
    /**
     * @var
     */
    protected $attributeFilter;

    /**
     *
     */
    public function init()
    {
        $this->attributeFilter = Yii::app()->getComponent('attributesFilter');
    }

    /**
     * @param array $mainSearchAttributes
     * @param array $typeSearchAttributes
     * @return CActiveDataProvider
     */
    public function getByFilter(array $mainSearchAttributes, array $typeSearchAttributes)
    {
        $criteria = new CDbCriteria();
        $criteria->select = 't.*';
        $criteria->params = [];
        $criteria->addCondition('t.status = :status');
        $criteria->params['status'] = Product::STATUS_ACTIVE;


        //поиск по категории, производителю и цене
        foreach ($this->attributeFilter->getMainSearchParams() as $param => $field) {

            if (empty($mainSearchAttributes[$param])) {
                continue;
            }

            if ($param === 'category') {
                $categories = [];

                foreach ($mainSearchAttributes[$param] as $categoryId) {
                    $categories[] = $categoryId;
                    $categories = CMap::mergeArray($categories, StoreCategory::model()->getChildsArray($categoryId));
                }

                $criteria->with = ['categoryRelation' => ['together' => true]];
                $criteria->addInCondition('categoryRelation.category_id', array_unique($categories));
                $criteria->addInCondition('t.category_id', array_unique($categories), 'OR');
                $criteria->group = 't.id';
                continue;
            }

            if (isset($mainSearchAttributes[$param]['from'], $mainSearchAttributes[$param]['to'])) {
                $criteria->addBetweenCondition("t." . $field, $mainSearchAttributes[$param]['from'], $mainSearchAttributes[$param]['to']);
            } elseif (isset($mainSearchAttributes[$param]['from']) && !isset($mainSearchAttributes[$param]['to'])) {
                $criteria->addCondition("t.{$field} >= :attr_{$field}");
                $criteria->params[":attr_{$field}"] = $mainSearchAttributes[$param]['from'];
            } elseif (isset($mainSearchAttributes[$param]['to']) && !isset($mainSearchAttributes[$param]['from'])) {
                $criteria->addCondition("t.{$field} <= :attr_{$field}");
                $criteria->params[":attr_{$field}"] = $mainSearchAttributes[$param]['to'];
            } else {
                $criteria->addInCondition("t." . $field, $mainSearchAttributes[$param]);
            }
        }

        //поиск по названию
        if (!empty($mainSearchAttributes[AttributeFilter::MAIN_SEARCH_PARAM_NAME])) {
            $criteria->addSearchCondition('name', $mainSearchAttributes[AttributeFilter::MAIN_SEARCH_PARAM_NAME], true);
        }

        $criteria->mergeWith($this->buildCriteriaForTypeAttributes($typeSearchAttributes));

        return new CActiveDataProvider(
            'Product',
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
     * @param array $typeSearchAttributes
     * @return CDbCriteria
     */
    protected function buildCriteriaForTypeAttributes(array $typeSearchAttributes)
    {
        $criteria = new CDbCriteria();
        $criteria->params = [];

        $i = 0;

        foreach ($typeSearchAttributes as $attribute => $params) {

            if (empty($params['value'])) {
                continue;
            }

            $alias = "attributes_values_{$i}";

            $criteria->join .= " JOIN {{store_product_attribute_value}} {$alias} ON t.id = {$alias}.product_id ";

            //@TODO подумать как улучшить
            if (is_array($params['value'])) {
                if (isset($params['value']['from'], $params['value']['to'])) {
                    $between = new CDbCriteria();
                    $between->addBetweenCondition("{$alias}." . $params['column'], $params['value']['from'], $params['value']['to']);
                    $between->addCondition("{$alias}.attribute_id = :attributeId_{$i}");
                    $between->params[":attributeId_{$i}"] = (int)$params['attribute_id'];
                    $criteria->mergeWith($between);
                } elseif (isset($params['value']['from']) && !isset($params['value']['to'])) {
                    $between = new CDbCriteria();
                    $between->addCondition("{$alias}.attribute_id = :attributeId_{$i}");
                    $between->addCondition("{$alias}.{$params['column']} >= :attr_{$i}");
                    $between->params[":attributeId_{$i}"] = (int)$params['attribute_id'];
                    $between->params[":attr_{$i}"] = $params['value']['from'];
                    $criteria->mergeWith($between);
                } elseif (isset($params['value']['to']) && !isset($params['value']['from'])) {
                    $between = new CDbCriteria();
                    $between->addCondition("{$alias}.attribute_id = :attributeId_{$i}");
                    $between->addCondition("{$alias}.{$params['column']} <= :attr_{$i}");
                    $between->params[":attributeId_{$i}"] = (int)$params['attribute_id'];
                    $between->params[":attr_{$i}"] = $params['value']['to'];
                    $criteria->mergeWith($between);
                } else {
                    $in = new CDbCriteria();
                    $in->addInCondition("{$alias}." . $params['column'], $params['value']);
                    $criteria->mergeWith($in);
                }
            } else {
                $condition = new CDbCriteria();
                $condition->addCondition("{$alias}.attribute_id = :attributeId_{$i}");
                $condition->params[":attributeId_{$i}"] = (int)$params['attribute_id'];
                $condition->addColumnCondition(["{$alias}." . $params['column'] => $params['value']]);
                $criteria->mergeWith($condition);
            }

            $i++;
        }

        return $criteria;
    }


    /**
     * @return CActiveDataProvider
     */
    public function getListForIndexPage()
    {
        $criteria = new CDbCriteria();
        $criteria->select = 't.*';
        $criteria->scopes = ['published'];

        return new CActiveDataProvider(
            'Product',
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
     * @param integer $limit
     * @return CActiveDataProvider
     */
    public function getListForCategory(StoreCategory $category, $limit = null)
    {
        $categories = $category->getChildsArray();
        $categories[] = $category->id;

        $criteria = new CDbCriteria();
        $criteria->select = 't.*';
        $criteria->with = ['categoryRelation' => ['together' => true]];
        $criteria->addInCondition('categoryRelation.category_id', $categories);
        $criteria->addInCondition('t.category_id', $categories, 'OR');
        $criteria->group = 't.id';
        $criteria->scopes = ['published'];
        if($limit){
            $criteria->limit = $limit;
        }

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
     * @param $query
     * @return array
     */
    public function search($query)
    {
        $criteria = new CDbCriteria();
        $criteria->params = [];
        $criteria->addSearchCondition('name', $query, true);
        return Product::model()->published()->findAll($criteria);
    }

    /**
     * @param $slug
     * @param array $with
     * @return mixed
     */
    public function getBySlug($slug, array $with = ['producer', 'type.typeAttributes', 'images', 'category', 'variants'])
    {
        return Product::model()->published()->with($with)->find('t.slug = :slug', [':slug' => $slug]);
    }

    /**
     * @param $id
     * @param array $with
     * @return mixed
     */
    public function getById($id, array $with = ['producer', 'type.typeAttributes', 'images', 'category', 'variants'])
    {
        return Product::model()->published()->with($with)->findByPk($id);
    }

    /**
     * @param $name
     * @return array|mixed|null
     */
    public function searchByName($name)
    {
        $criteria = new CDbCriteria();
        $criteria->addSearchCondition('name', $name);
        $provider = new CActiveDataProvider(Product::model()->published(), [
            'criteria' => $criteria
        ]);
        return new CDataProviderIterator($provider);
    }

    /**
     * Get products by brand
     *
     * @param Producer $producer
     * @return CActiveDataProvider
     */
    public function getByBrandProvider(Producer $producer)
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'producer_id = :producer_id';
        $criteria->scopes = ['published'];
        $criteria->params = [
            ':producer_id' => $producer->id
        ];

        return new CActiveDataProvider(Product::model(), [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => (int)Yii::app()->getModule('store')->itemsPerPage,
                'pageVar' => 'page',
            ],
            'sort' => [
                'sortVar' => 'sort',
                'defaultOrder' => 't.position'
            ],
        ]);
    }
}
