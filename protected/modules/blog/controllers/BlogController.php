<?php

/**
 * BlogController контроллер для блогов на публичной части сайта
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.blog.controllers
 * @since 0.1
 *
 */
class BlogController extends \yupe\components\controllers\FrontController
{
    /**
     * Выводит список блогов
     *
     * @return void
     */
    public function actionIndex()
    {
        $blogs = new Blog('search');
        $blogs->unsetAttributes();
        $blogs->status = Blog::STATUS_ACTIVE;

        if (isset($_GET['Blog']['name'])) {
            $blogs->name = CHtml::encode($_GET['Blog']['name']);
        }

        $this->render('index', ['blogs' => $blogs]);
    }

    /**
     * Отобразить карточку блога
     *
     * @param  string $slug - url блога
     * @throws CHttpException
     *
     * @return void
     */
    public function actionView($slug = null)
    {
        $blog = Blog::model()->getBySlug($slug);

        if ($blog === null) {
            throw new CHttpException(404, Yii::t(
                'BlogModule.blog',
                'Blog "{blog}" was not found!',
                ['{blog}' => $slug]
            ));
        }

        $this->render('view', ['blog' => $blog]);
    }

    /**
     * "вступление" в блог
     *
     * @throw CHttpException
     */
    public function actionJoin()
    {
        if (!Yii::app()->getRequest()->getIsPostRequest() || !Yii::app()->user->isAuthenticated()) {
            throw new CHttpException(404);
        }

        $blogId = (int)Yii::app()->request->getPost('blogId');

        if (!$blogId) {
            throw new CHttpException(404);
        }

        $blog = Blog::model()->get($blogId);

        if (!$blog) {
            throw new CHttpException(404);
        }

        if ($blog->join(Yii::app()->user->getId())) {
            Yii::app()->ajax->success(Yii::t('BlogModule.blog', 'You have joined!'));
        }

        //check if user is in blog but blocked
        if ($blog->hasUserInStatus(Yii::app()->getUser()->getId(), UserToBlog::STATUS_BLOCK)) {
            Yii::app()->ajax->failure(Yii::t('BlogModule.blog', 'You are blocking in this blog!'));
        }

        Yii::app()->ajax->failure(Yii::t('BlogModule.blog', 'An error occurred when you were joining the blog!'));
    }

    /**
     * "покинуть" блог
     *
     * @throw CHttpException
     */
    public function actionLeave()
    {
        if (!Yii::app()->getRequest()->getIsPostRequest() || !Yii::app()->user->isAuthenticated()) {
            throw new CHttpException(404);
        }

        $blogId = (int)Yii::app()->request->getPost('blogId');

        if (!$blogId) {
            throw new CHttpException(404);
        }

        $blog = Blog::model()->get($blogId);

        if (!$blog) {
            throw new CHttpException(404);
        }

        if ($blog->leave(Yii::app()->user->getId())) {
            Yii::app()->ajax->success(Yii::t('BlogModule.blog', 'You left the blog!'));
        }

        Yii::app()->ajax->failure(Yii::t('BlogModule.blog', 'An error occurred when you were leaving the blog!'));
    }

    /**
     * @param $slug
     * @throws CHttpException
     */
    public function actionMembers($slug)
    {
        $blog = Blog::model()->getBySlug($slug);

        if (null === $blog) {
            throw new CHttpException(404);
        }

        $this->render('members', ['blog' => $blog, 'members' => $blog->getMembersList()]);
    }
}
