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
        {
            throw new CHttpException('404', Yii::t('page', 'Страница не найдена!'));
        }

        $page = null;

        // превью
        if ((int)Yii::app()->request->getQuery('preview') === 1 && Yii::app()->user->isSuperUser())
        {
            $page = Page::model()->find('slug = :slug', array(':slug' => $slug));
        }
        else
        {
            $page = Page::model()->published()->find('slug = :slug', array(':slug' => $slug));
        }

        if (!$page)
        {
            throw new CHttpException('404', Yii::t('page', 'Страница не найдена!'));
        }

        // проверим что пользователь может просматривать эту страницу
        if (($page->isProtected == Page::PROTECTED_YES) && !Yii::app()->user->isAuthenticated())
        {
            Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('page', 'Для просмотра этой страницы Вам необходимо авторизоваться!'));
            $this->redirect(array(Yii::app()->getModule('user')->accountActivationSuccess));
        }

        $this->currentPage = $page;

        $this->render('page', array('page' => $page));
    }


    /**
     * getBreadCrumbs
     *
     * @return ARRAY
     *
     * Генерирует меню навигации по вложенным страницам для использования в zii.widgets.CBreadcrumbs
     *
     * @TODO пока только 2 уровня вложенности
     *
     */
    public function getBreadCrumbs()
    {
        $models = Page::model()->published()->find('id = :parentId', array(':parentId' => $this->currentPage->parentId));

        $pages = array();

        if ($models)
        {
            $pages[$models->title] = array('/page/page/show/', 'slug' => $models->slug);
        }

        array_push($pages, $this->currentPage->name);

        return $pages;
    }
}

?>