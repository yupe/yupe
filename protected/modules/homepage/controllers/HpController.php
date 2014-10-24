<?php

/**
 * HpController контроллер публичной части модуля homepage
 *
 * @category YupeController
 * @package  yupe.modules.homepage.controllers
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     http://yupe.ru
 *
 **/
class HpController extends yupe\components\controllers\FrontController
{
    /**
     * Index action:
     *
     * @return void
     */
    public function actionIndex()
    {
        $module = Yii::app()->getModule('homepage');

        $view = $data = null;

        if ($module->mode == HomepageModule::MODE_PAGE) {
            $view = 'page';

            $data = array(
                'page' => Page::model()->findByPk($module->target)
            );
        }

        if ($module->mode == HomepageModule::MODE_POSTS) {
            $view = 'posts';

            $dataProvider = new CActiveDataProvider(
                'Post', array(
                    'criteria' => new CDbCriteria(
                            array(
                                'condition' => 't.status = :status',
                                'params'    => array(':status' => Post::STATUS_PUBLISHED),
                                'limit'     => $module->limit,
                                'order'     => 't.publish_date DESC',
                                'with'      => array('createUser', 'blog', 'commentsCount'),
                            )
                        ),
                )
            );

            $data = array(
                'dataProvider' => $dataProvider
            );
        }

        $this->render($view, $data);
    }
}
