<?php
/**
 * Дефолтный контроллер сайта:
 *
 * @category YupeController
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3 (dev)
 * @link     http://yupe.ru
 *
 **/
class SiteController extends YFrontController
{
    const POST_PER_PAGE = 5;

    /**
     * Отображение главной страницы
     * 
     * @return void
     */
    public function actionIndex()
    {
        $this->render('welcome');
    }

    // раскомментируйте перед запуском сайта в работу
    /*
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Post', array(
            'criteria' => new CDbCriteria(array(
                'condition' => 't.status = :status',
                'params'    => array(':status' => Post::STATUS_PUBLISHED),
                'limit'     => self::POST_PER_PAGE,
                'order'     => 't.id DESC',
                'with'      => array('createUser', 'blog','commentsCount'),
            )),
        ));

        $this->render('index', array('dataProvider' => $dataProvider));
    }
    */
}