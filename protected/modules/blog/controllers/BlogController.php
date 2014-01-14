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
class BlogController extends yupe\components\controllers\FrontController
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
        $blogs->type = (int)Yii::app()->request->getQuery('type', Blog::TYPE_PUBLIC);

        if(isset($_GET['Blog']['name'])) {
            $blogs->name = CHtml::encode($_GET['Blog']['name']);
        }

        $this->render('index', array('blogs' => $blogs));
    }

    /**
     * Отобразить карточку блога
     *
     * @param string $slug - url блога
     * @throws CHttpException
     *
     * @return void
     */
    public function actionShow($slug = null)
    {     
        $blog = Blog::model()->with('posts', 'members', 'createUser')->getByUrl($slug)->published()->find();

        if ($blog === null){
           throw new CHttpException(404, Yii::t('BlogModule.blog', 'Blog "{blog}" was not found!', array('{blog}' => $slug)));
        }

        $this->render('show', array('blog' => $blog));
    }


    /**
     * "вступление" в блог
     *
     * @param int $blogId - id-блога
     *
     * @return void
     */
    public function actionJoin($blogId = null)
    {
        if (!Yii::app()->user->isAuthenticated()) {
            if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                Yii::app()->ajax->failure(Yii::t('BlogModule.blog', 'Please Sign in!'));
            } else {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('BlogModule.blog', 'Please Sign in!')
                );
                $this->redirect(array('/blog/blog/index'));
            }
        }

        if ($blogId === null && Yii::app()->getRequest()->getIsPostRequest()){
            $blogId = Yii::app()->getRequest()->getPost('blogId');
        }

        $errorMessage = false;

        $blogId = (int) $blogId;

        if (!$blogId) {
            $errorMessage = Yii::t('BlogModule.blog', 'blogId is not set!');
        }

        if (($blog = Blog::model()->loadModel($blogId)) === null) {
            $errorMessage = Yii::t('BlogModule.blog', 'Blog with id = {id} was not found!', array('{id}' => $blogId));
        }

        if ($errorMessage !== false) {
            if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                Yii::app()->ajax->failure($errorMessage);
            } else {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    $errorMessage
                );
                $this->redirect(array('/blog/blog/index'));
            }
        }

        if ($blog->userInBlog(Yii::app()->user->getId()) === false) {
            
            $blog->join(Yii::app()->user->getId());
            
            if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                Yii::app()->ajax->success(
                    array(
                        'message' => Yii::t('BlogModule.blog', 'You have joined the blog!'),
                        'content' => $this->renderPartial('_view', array('data' => $blog), true),
                    )
                );
            } else {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('BlogModule.blog', 'You have joined the blog!')
                );
                $this->redirect(array('/blog/blog/index'));
            }
        } else {
            if (Yii::app()->getRequest()->getIsAjaxRequest())
                Yii::app()->ajax->failure(
                    array(
                        'message' => Yii::t('BlogModule.blog', 'You have already joined this blog!'),
                    )
                );
            else
            {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('BlogModule.blog', 'You have already joined this blog!')
                );
                $this->redirect(array('/blog/blog/index'));
            }
        }
    }

    /**
     * "покинуть" блог
     *
     * @param int $blogId - id-блога
     *
     * @return void
     */
    public function actionUnjoin($blogId = null)
    {
        if (!Yii::app()->user->isAuthenticated()) {
            if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                Yii::app()->ajax->failure(Yii::t('BlogModule.blog', 'Please Sign in!'));
            } else {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('BlogModule.blog', 'Please Sign in!')
                );
                $this->redirect(array('/blog/blog/index'));
            }
        }

        if ($blogId === null && Yii::app()->getRequest()->getIsPostRequest() && Yii::app()->getRequest()->getIsAjaxRequest())
            $blogId = Yii::app()->getRequest()->getPost('blogId');

        $errorMessage = false;

        $blogId = (int) $blogId;
        if (!$blogId)
            $errorMessage = Yii::t('BlogModule.blog', 'blogId is not set!');

        if (($blog = Blog::model()->loadModel($blogId)) === null)
            $errorMessage = Yii::t('BlogModule.blog', 'Blog with id = {id} was not found!', array('{id}' => $blogId));
        elseif ($blog->createUser->id == Yii::app()->user->getId()) {
            if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                Yii::app()->ajax->failure(
                    Yii::t('BlogModule.blog', 'You are creator of this blog and you can\'t leave.')
                );
            } else {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    Yii::t('BlogModule.blog', 'You are creator of this blog and you can\'t leave.')
                );
                $this->redirect(array('/blog/blog/index'));
            }
        }


        if ($errorMessage !== false) {
            if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                Yii::app()->ajax->failure($errorMessage);
            } else {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    $errorMessage
                );
                $this->redirect(array('/blog/blog/index'));
            }
        }

        if (($userToBlog = $blog->userInBlog(Yii::app()->user->getId())) !== false) {
            
            if ($userToBlog->delete()) {
                if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                    Yii::app()->ajax->success(
                        array(
                            'message' => Yii::t('BlogModule.blog', 'You left the blog!'),
                            'content' => $this->renderPartial('_view', array('data' => $blog), true),
                        )
                    );
                } else {
                    Yii::app()->user->setFlash(
                        yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t('BlogModule.blog', 'You left the blog!')
                    );
                    $this->redirect(array('/blog/blog/index'));
                }
            } else {
                if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                    Yii::app()->ajax->failure(Yii::t('BlogModule.blog', 'An error occured when you were leaving the blog!'));
                } else {
                    Yii::app()->user->setFlash(
                        yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t('BlogModule.blog', 'An error occured when you were leaving the blog!')
                    );
                    $this->redirect(array('/blog/blog/index'));
                }
            }
        } else {
            if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                Yii::app()->ajax->failure(Yii::t('BlogModule.blog', 'You are not the member of this blog!'));
            }
            else
            {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('BlogModule.blog', 'You are not the member of this blog!')
                );
                $this->redirect(array('/blog/blog/index'));
            }
        }
    }
}