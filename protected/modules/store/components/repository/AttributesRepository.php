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
            'condition' => 't.is_filter = 1 AND t.type != :type AND products.category_id = :category',
            'params' => [
                ':category' => $category->id,
                ':type' => Attribute::TYPE_TEXT
            ],
            'join' => 'JOIN {{store_type_attribute}} ON t.id = {{store_type_attribute}}.attribute_id
                       JOIN {{store_type}} ON {{store_type_attribute}}.type_id = {{store_type}}.id
                       JOIN {{store_product}} AS products ON products.type_id = {{store_type}}.id',
        ]);

        return Attribute::model()->findAll($criteria);
    }
}