<?php

use yupe\components\controllers\FrontController;

/**
 * PageController публичный контроллер для работы со страницами
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.page.controllers
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @since 0.1
 *
 */
class PageController extends FrontController
{
    /**
     * Текущая просматриваемая страница
     */
    public $currentPage;

    /**
     * экшн для отображения конкретной страницы, отображает опубликованные страницы и превью
     */
    public function actionView($slug)
    {
        $model = ((int)Yii::app()->getRequest()->getQuery('preview') === 1 && Yii::app()->getUser()->isSuperUser())
            ? Page::model()->find(
                'slug = :slug AND (lang=:lang OR (lang IS NULL))',
                [
                    ':slug' => $slug,
                    ':lang' => Yii::app()->language,
                ]
            )
            : Page::model()->published()->find(
                'slug = :slug AND (lang = :lang OR (lang = :deflang))',
                [
                    ':slug' => $slug,
                    ':lang' => Yii::app()->language,
                    ':deflang' => $this->yupe->defaultLanguage,
                ]
            );

        if (null === $model) {
            throw new CHttpException(404, Yii::t('PageModule.page', 'Page was not found'));
        }

        // проверим что пользователь может просматривать эту страницу
        if ($model->isProtected() && !Yii::app()->getUser()->isAuthenticated()) {
            Yii::app()->getUser()->setFlash(
                yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                Yii::t('PageModule.page', 'You must be authorized user for view this page!')
            );

            $this->redirect([Yii::app()->getModule('user')->accountActivationSuccess]);
        }

        $this->currentPage = $model;

        $view = $model->view ? $model->view : 'view';

        $this->render($view, ['model' => $model]);
    }

    /**
     * Генерирует меню навигации по вложенным страницам для использования в zii.widgets.CBreadcrumbs
     */
    public function getBreadCrumbs()
    {
        $pages = [];
        if ($this->currentPage->parentPage) {
            $pages = $this->getBreadCrumbsRecursively($this->currentPage->parentPage);
        }

        $pages = array_reverse($pages);
        $pages[] = $this->currentPage->title;

        return $pages;
    }

    /**
     * Рекурсивно возвращает пригодный для zii.widgets.CBreadcrumbs массив, начиная со страницы $page
     * @param  Page $page
     * @return array
     * @internal param int $pageId
     */
    private function getBreadCrumbsRecursively(Page $page)
    {
        $pages = [];
        $pages[$page->title] = $page->getUrl();
        $pp = $page->parentPage;
        if ($pp) {
            $pages += $this->getBreadCrumbsRecursively($pp);
        }

        return $pages;
    }
}
