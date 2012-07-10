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
     * сurrentPage
     *
     * Текущая просматриваемая страница
     *
     */
    public $currentPage;


    /**
     * actionShow
     *
     * экшн для отображения конкретной страницы
     * отображает опубликованные страницы и превью
     */
    public function actionShow()
    {
        $slug = Yii::app()->request->getQuery('slug');

        if (!$slug)        
            throw new CHttpException('404', Yii::t('page', 'Страница не найдена!'));        

        $this->currentPage = null;

        // превью
        if ((int)Yii::app()->request->getQuery('preview') === 1 && Yii::app()->user->isSuperUser())
            $this->currentPage = Page::model()->find('slug = :slug', array(':slug' => $slug));
        else
            $this->currentPage = Page::model()->published()->find('slug = :slug', array(':slug' => $slug));

        if (!$this->currentPage)
            throw new CHttpException('404', Yii::t('page', 'Страница не найдена!'));        

        // проверим что пользователь может просматривать эту страницу
        if (($this->currentPage->is_protected == Page::PROTECTED_YES) && !Yii::app()->user->isAuthenticated())
        {
            Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('page', 'Для просмотра этой страницы Вам необходимо авторизоваться!'));
            $this->redirect(array(Yii::app()->getModule('user')->accountActivationSuccess));
        }

        $this->render('page', array('page' => $this->currentPage));
    }



    //@TODO Методы, расположенные ниже лучше всего вынести в модель (я так думаю)

    /**
     * getBreadCrumbs
     *
     * @return ARRAY
     *
     * Генерирует меню навигации по вложенным страницам для использования в zii.widgets.CBreadcrumbs
     *
     *
     */
    public function getBreadCrumbs()
    {
        $pages = array();
        if($this->currentPage->parentPage)
            $pages = $this->getBreadCrumbsRecursively($this->currentPage->parentPage);

        $pages = array_reverse($pages);
        array_push($pages, $this->currentPage->title);
        return $pages;
    }

    /**
     * Рекурсивно возвращает пригодный для zii.widgets.CBreadcrumbs массив, начиная со страницы $page
     * @param int $pageId 
     */
    private function getBreadCrumbsRecursively(Page $page){
        $pages = array();
        $pages[$page->title] = array('/page/page/show/', 'slug' => $page->slug);
        $pp = $page->parentPage;
        if($pp)
            $pages+= $this->getBreadCrumbsRecursively($pp);
        return $pages;
    }
}