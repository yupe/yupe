<?php
/**
 *
 * PageController
 *
 * Контроллер для работы со страничками в публичной части сайта
 *
 * @author  xoma <aopeykin@yandex.ru> <http://yupe.ru>
 * @package yupe.modules.page.controllers
 *
 *
 */
class PageController extends YFrontController
{
    /**
     * Текущая просматриваемая страница
     */
    public $currentPage;

    /**
     * экшн для отображения конкретной страницы, отображает опубликованные страницы и превью
     */
    public function actionShow($slug)
    {
        $page = null;
        // превью
        $page = ((int) Yii::app()->request->getQuery('preview') === 1 && Yii::app()->user->isSuperUser())
            ? Page::model()->find('slug = :slug AND (lang=:lang OR (lang IS NULL))', array(
                ':slug' => $slug,
                ':lang' => Yii::app()->language,
            ))
            : Page::model()->published()->find('slug = :slug AND (lang = :lang OR (lang = :deflang))', array(
                ':slug'    => $slug,
                ':lang'    => Yii::app()->language,
                ':deflang' => Yii::app()->getModule('yupe')->defaultLanguage,
            ));

        if (!$page)
            throw new CHttpException('404', Yii::t('PageModule.page', 'Страница не найдена!'));

        // проверим что пользователь может просматривать эту страницу
        if ($page->is_protected == Page::PROTECTED_YES && !Yii::app()->user->isAuthenticated())
        {
            Yii::app()->user->setFlash(
                YFlashMessages::NOTICE_MESSAGE,
                Yii::t('PageModule.page', 'Для просмотра этой страницы Вам необходимо авторизоваться!')
            );
            $this->redirect(array(Yii::app()->getModule('user')->accountActivationSuccess));
        }
        $this->currentPage = $page;
        $this->render('page', array('page' => $page));
    }

    /**
     * Генерирует меню навигации по вложенным страницам для использования в zii.widgets.CBreadcrumbs
     */
    public function getBreadCrumbs()
    {
        $pages = array();
        if ($this->currentPage->parentPage)
            $pages = $this->getBreadCrumbsRecursively($this->currentPage->parentPage);

        $pages = array_reverse($pages);
        $pages[] = $this->currentPage->title;
        return $pages;
    }

    /**
     * Рекурсивно возвращает пригодный для zii.widgets.CBreadcrumbs массив, начиная со страницы $page
     * @param Page $page
     * @return array
     * @internal param int $pageId
     */
    private function getBreadCrumbsRecursively(Page $page)
    {
        $pages = array();
        $pages[$page->title] = array('/page/page/show', 'slug' => $page->slug);
        $pp = $page->parentPage;
        if ($pp)
            $pages += $this->getBreadCrumbsRecursively($pp);
        return $pages;
    }
}