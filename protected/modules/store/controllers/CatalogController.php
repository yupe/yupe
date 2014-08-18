<?php

class CatalogController extends yupe\components\controllers\FrontController
{
    const PRODUCTS_PER_PAGE = 20;

    public function actionShow($name)
    {
        $products = Product::model()->published()->find('alias = :alias', array(':alias' => $name));

        if (!$products) {
            throw new CHttpException(404, Yii::t('StoreModule.catalog', 'Product was not found!'));
        }

        $this->render('product', array('product' => $products));
    }

    public function actionIndex()
    {
        $this->actionCategory();
    }

    public function actionCategory($path = null)
    {
        $criteria = new CDbCriteria();
        if ($path) {
            $cat = StoreCategory::model()->findByPath($path);
            if ($cat === null) {
                throw new CHttpException(404, 'Not found');
            }
            $criteria->with = array('categoryRelation' => array('together' => true));
            $criteria->compare('categoryRelation.category_id', $cat->id);
        }

        if (isset($_GET['q'])) {
            $criteria->addSearchCondition('name', $_GET['q']);
            $criteria->addSearchCondition('sku', $_GET['q'], true, 'OR');
        }
        if (isset($_GET['price-from'])) {
            $criteria->addCondition('price >= ' . floatval($_GET['price-from']));
        }
        if (isset($_GET['price-to']) && floatval($_GET['price-to']) > 0) {
            $criteria->addCondition('price <= ' . $_GET['price-to']);
        }

        $dataProvider = new CActiveDataProvider(
            Product::model(), array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => self::PRODUCTS_PER_PAGE,
                    'pageVar' => 'page',
                ),
                'sort' => array(
                    'sortVar' => 'sort',
                ),
            )
        );

        $this->render('index', array('dataProvider' => $dataProvider, 'category' => $cat));
    }

    public function actionAutocomplete()
    {
        $term = $_GET['term'];
        $res = array();
        if (strlen($term) > 2) {
            $q = "SELECT name FROM {{store_product}} WHERE name LIKE :search or sku LIKE :search";
            $command = Yii::app()->db->createCommand($q);
            $command->bindValue(":search", '%' . $term . '%', PDO::PARAM_STR);
            $res = $command->queryColumn();
        }
        echo CJSON::encode($res);
        Yii::app()->end();
    }
}
