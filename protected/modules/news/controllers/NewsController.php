<?php

/**
 * NewsController контроллер для работы с новостями в публичной части сайта
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.news.controllers
 * @since 0.1
 *
 */
class NewsController extends yupe\components\controllers\FrontController
{
    public function actionShow($alias)
    {
        $news = News::model()->published();

        $news = ($this->isMultilang())
            ? $news->language(Yii::app()->language)->find('alias = :alias', array(':alias' => $alias))
            : $news->find('alias = :alias', array(':alias' => $alias));

        if (!$news) {
            throw new CHttpException(404, Yii::t('NewsModule.news', 'News article was not found!'));
        }

        // проверим что пользователь может просматривать эту новость
        if ($news->is_protected == News::PROTECTED_YES && !Yii::app()->user->isAuthenticated()) {
            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                Yii::t('NewsModule.news', 'You must be an authorized user for view this page!')
            );

            $this->redirect(array(Yii::app()->getModule('user')->accountActivationSuccess));
        }

        $this->render('show', array('news' => $news));
    }

    public function actionIndex()
    {
        $dbCriteria = new CDbCriteria(array(
            'condition' => 't.status = :status',
            'params'    => array(
                ':status' => News::STATUS_PUBLISHED,
            ),
            'limit'     => $this->module->perPage,
            'order'     => 't.creation_date DESC',
            'with'      => array('user'),
        ));

        if (!Yii::app()->user->isAuthenticated()) {
            $dbCriteria->mergeWith(
                array(
                    'condition' => 'is_protected = :is_protected',
                    'params'    => array(
                        ':is_protected' => News::PROTECTED_NO
                    )
                )
            );
        }

        if ($this->isMultilang()) {
            $dbCriteria->mergeWith(
                array(
                    'condition' => 't.lang = :lang',
                    'params'    => array(':lang' => Yii::app()->language),
                )
            );
        }

        $dataProvider = new CActiveDataProvider('News', array('criteria' => $dbCriteria));
        $this->render('index', array('dataProvider' => $dataProvider));
    }
}
