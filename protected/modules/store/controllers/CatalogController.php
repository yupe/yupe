<?php

class CatalogController extends yupe\components\controllers\FrontController
{
    public function actionShow($name)
    {
        $products = Product::model()->published()->find('alias = :alias', array(':alias' => $name));

        if (!$products) {
            throw new CHttpException(404, Yii::t('StoreModule.catalog', 'Product was not found!'));
        }

        $this->render('product', ['product' => $products]);
    }

    public function actionIndex()
    {
        $tree = (new StoreCategory())->getMenuList(5);

        $this->render('index', array('tree' => $tree,'dataProvider' => (new ProductRepository())->getListForIndexPage()));
    }

    public function actionCategory($path)
    {
        $category = StoreCategory::model()->getByAlias($path);

        if(null === $category) {
            throw new CHttpException(404);
        }

        $this->render('category', array('dataProvider' => (new ProductRepository())->getListForCategory($category), 'category' => $category));
    }

    public function actionAutocomplete()
    {
        $query  = Yii::app()->getRequest()->getQuery('term');
        $result = [];
        if (strlen($query) > 2) {
            $result = (new ProductRepository())->searchLite($query);
        }
        echo CJSON::encode($result);
        Yii::app()->end();
    }
}
