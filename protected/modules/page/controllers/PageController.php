<?php

use yupe\components\controllers\FrontController;

/**
 * PageController публичный контроллер для работы со страницами
 *
 * @author yupe team <team@yupe.ru>
 * @link https://yupe.ru
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
        $isPreview = ((int)Yii::app()->getRequest()->getQuery('preview') === 1 && Yii::app()->getUser()->isSuperUser());
        if ($isPreview) {
            $model = Page::model()->find(
                'slug = :slug AND (lang=:lang OR (lang IS NULL))',
                [
                    ':slug' => $slug,
                    ':lang' => Yii::app()->getLanguage(),
                ]
            );
        } else {
            $criteria = [
                'condition' => 'slug = :slug AND (lang = :lang OR (lang = :deflang))',
                'params' => [
                    ':slug' => $slug,
                    ':lang' => Yii::app()->getLanguage(),
                    ':deflang' => $this->yupe->defaultLanguage,
                ],
                'order' => 'FIELD(lang, "' . Yii::app()->getLanguage() . '", "' . $this->yupe->defaultLanguage . '")'
            ];
            $model = Page::model()->published()->find($criteria);
        }

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

        $this->render($model->view ?: 'view', ['model' => $model]);
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
        $pages[$page->title] = Yii::app()->createUrl('/page/page/view', ['slug' => $page->slug]);
        $pp = $page->parentPage;

        if ($pp) {
            $pages += $this->getBreadCrumbsRecursively($pp);
        }

        return $pages;
    }
}
