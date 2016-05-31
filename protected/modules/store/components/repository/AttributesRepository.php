<?php

/**
 * Class AttributesRepository
 */
class AttributesRepository extends CApplicationComponent
{
    /**
     * @param StoreCategory $category
     * @return static[]
     */
    public function getForCategory(StoreCategory $category)
    {
        $criteria = new CDbCriteria([
            'select' => ['t.name', 't.id'],
            'condition' => 'products.category_id = :category',
            'params' => [
                ':category' => $category->id,
            ],
            'join' => 'LEFT JOIN {{store_type_attribute}} ON t.id = {{store_type_attribute}}.attribute_id
                       LEFT JOIN {{store_type}} ON {{store_type_attribute}}.type_id = {{store_type}}.id
                       LEFT JOIN {{store_product}} AS products ON products.type_id = {{store_type}}.id',
        ]);

        return Attribute::model()->findAll($criteria);
    }
}