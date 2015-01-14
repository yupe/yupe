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
class HpController extends \yupe\components\controllers\FrontController
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

            $target = Page::model()->findByPk($module->target);
            if (null === $target) {
                throw new CHttpException('404', Yii::t('HomepageModule.page', 'Page was not found'));
            }
            $page = Page::model()->find(
                    'slug = :slug AND lang = :lang',
                    [
                        ':slug'    => $target->slug,
                        ':lang'    => Yii::app()->language,
                    ]
                );
            $page = $page ?: $target;
            $view = $page->view ?: 'page';

            $data = [
                'page' => $page
            ];
        }

        if ($module->mode == HomepageModule::MODE_POSTS) {
            $view = 'posts';

            $dataProvider = new CActiveDataProvider(
                'Post', [
                    'criteria' => new CDbCriteria(
                            [
                                'condition' => 't.status = :status',
                                'params'    => [':status' => Post::STATUS_PUBLISHED],
                                'limit'     => $module->limit,
                                'order'     => 't.publish_date DESC',
                                'with'      => ['createUser', 'blog', 'commentsCount'],
                            ]
                        ),
                ]
            );

            $data = [
                'dataProvider' => $dataProvider
            ];
        }

        $this->render($view, $data);
    }
}
