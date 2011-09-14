<?php
class NewsController extends YFrontController
{
    public function actionShow($title)
    {
        $news = News::model()->published()->find('alias = :alias', array(':alias' => $title));

        if (!$news)
        {
            throw new CHttpException(404, Yii::t('news', 'Новость не найдена!'));
        }

        $this->render('news', array('news' => $news));
    }
}

?>