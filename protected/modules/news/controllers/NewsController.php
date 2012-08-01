<?php
class NewsController extends YFrontController
{
    const NEWS_PER_PAGE = 16;

    public function actionShow($title)
    {
        if ( $this->isMultilang() )
            $news = News::model()->published()->language(Yii::app()->language)->find('alias = :alias', array(':alias' => $title));
        else
            $news = News::model()->published()->find('alias = :alias', array(':alias' => $title));

        if (!$news)
            throw new CHttpException(404, Yii::t('news', 'Новость не найдена!'));

        $this->render('news', array('news' => $news));
    }

    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('News', array(
            'criteria' => new CDbCriteria(array(
                'condition' => 't.status = :status',
                'params' => array(':status' => News::STATUS_PUBLISHED),
                'limit' => self::NEWS_PER_PAGE,
                'order' => 't.creation_date DESC',
                'with' => 'user'
            ))
        ));

        $this->render('index', array('dataProvider' => $dataProvider));
    }
}