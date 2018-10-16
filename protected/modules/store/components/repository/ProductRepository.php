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
        /** @var StoreModule $module */
        $module = Yii::app()->getModule('store');

        $criteria = new CDbCriteria([
            'select' => 't.*',
            'distinct' => true,
            'params' => [],
        ]);
        $criteria->addCondition('t.status = :status');
        $criteria->params['status'] = Product::STATUS_ACTIVE;

        //поиск по категории, производителю и цене
        foreach ($this->attributeFilter->getMainSearchParams() as $param => $field) {

            if (empty($mainSearchAttributes[$param])) {
                continue;
            }

            if ('category' === $param) {

                $categories = [];

                foreach ($mainSearchAttributes[$param] as $categoryId) {
                    $categories[] = (int)$categoryId;
                    $categories = CMap::mergeArray($categories, StoreCategory::model()->getChildsArray($categoryId));
                }

                $builder = new CDbCommandBuilder(Yii::app()->getDb()->getSchema());

                $criteria->addInCondition('t.category_id', array_unique($categories));
                $criteria->addCondition(sprintf('t.id IN (SELECT product_id FROM {{store_product_category}} WHERE %s)',
                    $builder->createInCondition('{{store_product_category}}', 'category_id', $categories)), 'OR');

                continue;
            }

            if (isset($mainSearchAttributes[$param]['from'], $mainSearchAttributes[$param]['to'])) {
                $criteria->addBetweenCondition(
                    "t.".$field,
                    $mainSearchAttributes[$param]['from'],
                    $mainSearchAttributes[$param]['to']
                );
            } elseif (isset($mainSearchAttributes[$param]['from']) && !isset($mainSearchAttributes[$param]['to'])) {
                $criteria->addCondition("t.{$field} >= :attr_{$field}");
                $criteria->params[":attr_{$field}"] = $mainSearchAttributes[$param]['from'];
            } elseif (isset($mainSearchAttributes[$param]['to']) && !isset($mainSearchAttributes[$param]['from'])) {
                $criteria->addCondition("t.{$field} <= :attr_{$field}");
                $criteria->params[":attr_{$field}"] = $mainSearchAttributes[$param]['to'];
            } else {
                $criteria->addInCondition("t.".$field, $mainSearchAttributes[$param]);
            }
        }

        //поиск по названию и артикулу
        if (!empty($mainSearchAttributes[AttributeFilter::MAIN_SEARCH_PARAM_NAME])) {

            $term = trim($mainSearchAttributes[AttributeFilter::MAIN_SEARCH_PARAM_NAME]);

            $words = explode(' ', $term);

            foreach ($words as $word) {
                $word = trim($word);
                $criteria->addSearchCondition('t.name', $word, true, 'AND');
                $criteria->addSearchCondition('t.sku', $word, true, 'OR');
            }
        }

        $criteria->mergeWith($this->buildCriteriaForTypeAttributes($typeSearchAttributes));

        return new CActiveDataProvider(
            'Product',
            [
                'criteria' => $criteria,
                'pagination' => [
                    'pageSize' => (int)$module->itemsPerPage,
                    'pageVar' => 'page',
                ],
                'sort' => [
                    'sortVar' => 'sort',
                    'defaultOrder' => $module->getDefaultSort(),
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
                    $between->addBetweenCondition(
                        "{$alias}.".$params['column'],
                        $params['value']['from'],
                        $params['value']['to']
                    );
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
                    $in->addInCondition("{$alias}.".$params['column'], $params['value']);
                    $criteria->mergeWith($in);
                }
            } else {
                $condition = new CDbCriteria();
                $condition->addCondition("{$alias}.attribute_id = :attributeId_{$i}");
                $condition->params[":attributeId_{$i}"] = (int)$params['attribute_id'];
                $condition->addColumnCondition(["{$alias}.".$params['column'] => $params['value']]);
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
        /** @var StoreModule $module */
        $module = Yii::app()->getModule('store');

        $criteria = new CDbCriteria();
        $criteria->select = 't.*';
        $criteria->scopes = ['published'];

        return new CActiveDataProvider(
            'Product',
            [
                'criteria' => $criteria,
                'pagination' => [
                    'pageSize' => (int)$module->itemsPerPage,
                    'pageVar' => 'page',
                ],
                'sort' => [
                    'sortVar' => 'sort',
                    'defaultOrder' => $module->getDefaultSort(),
                ],
            ]
        );
    }

    /**
     * @param StoreCategory $category
     * @param bool $withChild
     * @param null $limit
     * @return CActiveDataProvider
     */
    public function getListForCategory(StoreCategory $category, $withChild = true, $limit = null)
    {
        $categories = [];
        /** @var StoreModule $module */
        $module = Yii::app()->getModule('store');

        if (true === $withChild) {
            $categories = $category->getChildsArray();
        }

        $categories[] = $category->id;

        $criteria = new CDbCriteria([
            'scopes' => ['published'],
        ]);

        $builder = new CDbCommandBuilder(Yii::app()->getDb()->getSchema());

        $criteria->addInCondition('t.category_id', array_unique($categories));
        $criteria->addCondition(sprintf('t.id IN (SELECT product_id FROM {{store_product_category}} WHERE %s)',
            $builder->createInCondition('{{store_product_category}}', 'category_id', $categories)), 'OR');

        $pagination = [
            'pageSize' => (int)$module->itemsPerPage,
            'pageVar' => 'page',
        ];

        if ($limit) {
            $pagination = false;
            $criteria->limit = (int)$limit;
        }

        return new CActiveDataProvider(
            Product::model(),
            [
                'criteria' => $criteria,
                'pagination' => $pagination,
                'sort' => [
                    'sortVar' => 'sort',
                    'defaultOrder' => $module->getDefaultSort(),
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
    public function getBySlug(
        $slug,
        array $with = ['producer', 'type.typeAttributes', 'images', 'category', 'variants', 'attributesValues']
    ) {
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
        $provider = new CActiveDataProvider(
            Product::model()->published(), [
                'criteria' => $criteria,
            ]
        );

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
        /** @var StoreModule $module */
        $module = Yii::app()->getModule('store');

        $criteria = new CDbCriteria();
        $criteria->condition = 'producer_id = :producer_id';
        $criteria->scopes = ['published'];
        $criteria->params = [
            ':producer_id' => $producer->id,
        ];

        return new CActiveDataProvider(
            Product::model(), [
                'criteria' => $criteria,
                'pagination' => [
                    'pageSize' => (int)$module->itemsPerPage,
                    'pageVar' => 'page',
                ],
                'sort' => [
                    'sortVar' => 'sort',
                    'defaultOrder' => $module->getDefaultSort(),
                ],
            ]
        );
    }

    /**
     * @param array $ids
     * @return CActiveDataProvider
     */
    public function getByIds(array $ids)
    {
        /** @var StoreModule $module */
        $module = Yii::app()->getModule('store');

        $criteria = new CDbCriteria();
        $criteria->scopes = ['published'];
        $criteria->addInCondition('t.id', $ids);

        return new CActiveDataProvider(
            Product::model(), [
                'criteria' => $criteria,
                'pagination' => [
                    'pageSize' => (int)$module->itemsPerPage,
                    'pageVar' => 'page',
                ],
                'sort' => [
                    'sortVar' => 'sort',
                    'defaultOrder' => $module->getDefaultSort(),
                ],
            ]
        );
    }

    /**
     * @param Product $product
     * @param null $typeCode
     * @return CActiveDataProvider
     */
    public function getLinkedProductsDataProvider(Product $product, $typeCode = null)
    {
        $criteria = new CDbCriteria();
        $criteria->scopes = ['published'];
        $criteria->order = 'linked.position DESC';
        $criteria->join  = ' JOIN {{store_product_link}} linked ON t.id = linked.linked_product_id';
        $criteria->compare('linked.product_id', $product->id);
        if (null !== $typeCode) {
            $criteria->join .= ' JOIN {{store_product_link_type}} type ON type.id = linked.type_id';
            $criteria->compare('type.code', $typeCode);
        }

        return new CActiveDataProvider(
            'Product', [
                'criteria' => $criteria,
            ]
        );
    }

    /**
     * @param ProductBatchForm $form
     * @param array $ids
     * @return int
     */
    public function batchUpdate(ProductBatchForm $form, array $ids)
    {
        $attributes = $form->loadQueryAttributes();

        if (null !== $form->price) {
            $attributes['price'] = $this->getPriceQuery(
                'price',
                $form->price,
                (int)$form->price_op,
                (int)$form->price_op_unit
            );
        }

        if (null !== $form->discount_price) {
            $attributes['discount_price'] = $this->getPriceQuery(
                'discount_price',
                $form->discount_price,
                (int)$form->discount_price_op,
                (int)$form->discount_price_op_unit
            );
        }

        if (count($attributes) === 0) {
            return true;
        }

        $criteria = new CDbCriteria();
        $criteria->addInCondition('id', $ids);

        return Product::model()->updateAll($attributes, $criteria);
    }

    /**
     * @param $field
     * @param $price
     * @param $operation
     * @param $unit
     * @return float|CDbExpression
     */
    private function getPriceQuery($field, $price, $operation, $unit)
    {
        if (ProductBatchHelper::PRICE_EQUAL === $operation) {
            return $price;
        }

        $sign = ProductBatchHelper::PRICE_ADD === $operation ? '+' : '-';

        if (ProductBatchHelper::OP_PERCENT === $unit) {
            return new CDbExpression(sprintf('%s %s ((%s / 100) * :percent)', $field, $sign, $field), [
                ':percent' => $price
            ]);
        }

        return new CDbExpression(sprintf('%s %s :price', $field, $sign), [
            ':price' => $price
        ]);
    }
}
