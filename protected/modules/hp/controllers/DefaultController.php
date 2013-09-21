<?php
/**
 * Created by JetBrains PhpStorm.
 * User: aopeykin
 * Date: 19.07.13
 * Time: 16:36
 * To change this template use File | Settings | File Templates.
 */

class DefaultController extends yupe\components\controllers\FrontController
{
    public function actionIndex()
    {
        $module = Yii::app()->getModule('hp');

        $view = $data = null;

        if($module->mode == HpModule::MODE_PAGE)
        {
            $view = 'page';

            $data = array(
                'page' => Page::model()->findByPk($module->target)
            );
        }

        if($module->mode == HpModule::MODE_POSTS)
        {
            $view = 'posts';

            $dataProvider = new CActiveDataProvider('Post', array(
                'criteria' => new CDbCriteria(array(
                    'condition' => 't.status = :status',
                    'params'    => array(':status' => Post::STATUS_PUBLISHED),
                    'limit'     => $module->limit,
                    'order'     => 't.id DESC',
                    'with'      => array('createUser', 'blog','commentsCount'),
                )),
            ));

            $data = array(
                'dataProvider' => $dataProvider
            );
        }

        $this->render($view, $data);
    }
}