<?php
class CatalogController extends yupe\components\controllers\FrontController
{
    const GOOD_PER_PAGE = 10;

    public function actionShow($name)
    {
        $good = Good::model()->published()->find('alias = :alias', array(':alias' => $name));
        if (!$good)
            throw new CHttpException(404, Yii::t('CatalogModule.catalog', 'Product was not found!'));
        $this->render('good', array('good' => $good));
    }

    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider(Good::model()->published(), array(
            'criteria' => new CDbCriteria(array(
                'limit' => self::GOOD_PER_PAGE,
                'order' => 't.create_time DESC',
            )),
        ));
        $this->render('index', array('dataProvider' => $dataProvider));
    }
}