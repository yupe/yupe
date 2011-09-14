<?php
class SiteController extends YFrontController
{
    const NEWS_PER_PAGE = 5;

    public function actions()
    {
        return array(
            'page' => array(
                'class' => 'CViewAction',
            )
        );
    }

    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('News', array(
                                                             'criteria' => new CDbCriteria(array(
                                                                                                'condition' => 't.status = ' . News::STATUS_PUBLISHED,
                                                                                                'limit' => self::NEWS_PER_PAGE,
                                                                                                'order' => 't.creationDate DESC',
                                                                                                'with' => 'user'
                                                                                           ))
                                                        ));

        $this->render('index', array('dataProvider' => $dataProvider));
    }


}

?>
