<?php
class SiteController extends YFrontController
{
    const POST_PER_PAGE = 5;

    public function actions()
    {
        return array(
            'page' => array(
                'class' => 'CViewAction',
            )
        );
    }
    
    //удалите перед запуском сайта в работу
    public function actionIndex()
    {
        $this->render('welcome');
    }

    // раскомментируйте перед запуском сайта в работу
    /**public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Post', array(
            'criteria' => new CDbCriteria(array(
                'condition' => 't.status = :status',
                'params'    => array(':status' => Post::STATUS_PUBLISHED),
                'limit'     => self::POST_PER_PAGE,
                'order'     => 't.id DESC',
                'with'      => array('createUser', 'blog'),
            )),
        ));

        $this->render('index', array('dataProvider' => $dataProvider));
    }*/
}