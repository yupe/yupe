<?php

/**
 * ArchiveController контроллер для архива постов
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.blog.controllers
 * @since 0.1
 *
 */
class ArchiveController extends application\components\Controller
{
    public function actionIndex()
    {
        $this->render(
            'archive',
            ['data' => Post::model()->getArchive((int)Yii::app()->request->getQuery('blog'))]
        );
    }
}
