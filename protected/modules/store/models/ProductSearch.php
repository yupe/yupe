<?php

class ProductSearch extends Product
{
    public function searchNotFor($id)
    {
        $criteria = new CDbCriteria;

        $criteria->compare('name', $this->name, true);
        $criteria->compare('price', $this->price);
        $criteria->compare('sku', $this->sku, true);
        $criteria->compare('category_id', $this->category_id);
        $criteria->addNotInCondition('id', [$id]);

        return new CActiveDataProvider(get_class($this), [
            'criteria' => $criteria,
            'sort' => ['defaultOrder' => 't.position']
        ]);
    }
}
