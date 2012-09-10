<?php
class CatalogController extends YFrontController
{
    const NEWS_PER_PAGE = 10;

    public function actionShow($name)
    {
        //if ( $this->isMultilang() )
           //$good = Good::model()->published()->language(Yii::app()->language)->find('alias = :alias', array(':alias' => $name));
        //else
            $good = Good::model()->published()->find('alias = :alias', array(':alias' => $name));

        if (!$good)
            throw new CHttpException(404, Yii::t('news', 'Товар не найдена!'));

        $this->render('good', array('good' => $good));
    }

    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider(Good::model()->published(), array(
            'criteria' => new CDbCriteria(array(
                'limit' => self::NEWS_PER_PAGE,
                'order' => 't.create_time DESC',
            )),
        ));

        $this->render('index', array('dataProvider' => $dataProvider));
    }
}