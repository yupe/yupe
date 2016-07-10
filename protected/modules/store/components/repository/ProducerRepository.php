<?php

/**
 * Class ProducerRepository
 */
class ProducerRepository extends CApplicationComponent
{

    /**
     * @param StoreCategory $category
     * @param CDbCriteria $mergeWith
     * @return array|mixed|null
     */
    public function getForCategory(StoreCategory $category, CDbCriteria $mergeWith)
    {
        $criteria = new CDbCriteria([
            'order' => 't.sort ASC',
            'join' => 'LEFT JOIN {{store_product}} AS products ON products.producer_id = t.id',
            'distinct' => true
        ]);
        $criteria->addInCondition('products.category_id', [$category->id]);
        $criteria->mergeWith($mergeWith);
        
        return Producer::model()->findAll($criteria);
    }
}