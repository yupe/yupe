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
            'distinct' => true,
        ]);
        $criteria->addInCondition('products.category_id', [$category->id]);
        $criteria->mergeWith($mergeWith);

        return Producer::model()->findAll($criteria);
    }


    /**
     * @return CActiveDataProvider
     */
    public function getAllDataProvider()
    {
        $criteria = new CDbCriteria();
        $criteria->scopes = ['published'];
        $criteria->order = 'sort';

        return new CActiveDataProvider(
            'Producer', [
                'criteria' => $criteria,
                'pagination' => [
                    'pageSize' => 20,
                    'pageVar' => 'page',
                ],
            ]
        );
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function getBySlug($slug)
    {
        return Producer::model()->published()->find('slug = :slug', [':slug' => $slug]);
    }
}