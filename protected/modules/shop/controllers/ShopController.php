<?php

Yii::import('catalog.controllers.CatalogController');

class ShopController extends CatalogController
{
    public function actionIndex($category = null) {
        $criteria = new CDbCriteria(array(
            'limit' => self::GOOD_PER_PAGE,
            'order' => 't.create_time DESC',
        ));

        if(!empty($category)){
            $cat = Category::model()->findByAttributes(array('alias' => $category));
            if (!empty($cat)){
                $categories = $cat->descendants;
                $catlist = Chtml::listData($categories,'id','id');
                $catlist[] = $cat->id;
                $criteria->addInCondition('category_id', $catlist);
                //$criteria->compare('category_id', $cat->id);
            }
        }

        $dataProvider = new CActiveDataProvider(Good::model()->published(), array(
            'criteria' => $criteria,
        ));

        $this->render('index', array('dataProvider' => $dataProvider));
    }
}