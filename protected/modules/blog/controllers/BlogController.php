<?php
class BlogController extends yupe\components\controllers\FrontController
{
    /**
     * Выводит список блогов
     *
     * @return void
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider(
            'Blog', array(
                'criteria' => array(
                    'condition' => 't.status = :status',
                    'params'    => array(':status' => Blog::STATUS_ACTIVE),
                    'with'      => array('createUser', 'postsCount', 'membersCount'),
                    'order'     => 'create_date DESC',
                ),
            )
        );

        $this->render('index', array('dataProvider' => $dataProvider));
    }

    /**
     * Отобразить карточку блога
     *
     * @param string $slug - url блога
     *
     * @return void
     */
    public function actionShow($slug = null)
    {
        $blog = Blog::model()->with('posts')->getByUrl($slug)->find();

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
            if (Yii::app()->request->isAjaxRequest) {
                Yii::app()->ajax->failure(Yii::t('BlogModule.blog', 'Authorize, please!'));
            } else {
                Yii::app()->user->setFlash(
                    YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('BlogModule.blog', 'Authorize, please!')
                );
                $this->redirect(array('/blog/blog/index'));
            }
        }

        if ($blogId === null && Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest)
            $blogId = Yii::app()->request->getPost('blogId');

        $errorMessage = false;

        $blogId = (int) $blogId;
        if (!$blogId)
            $errorMessage = Yii::t('BlogModule.blog', 'blogId is not set!');

        if (($blog = Blog::model()->loadModel($blogId)) === null)
            $errorMessage = Yii::t('BlogModule.blog', 'Blog with id = {id} was not found!', array('{id}' => $blogId));

        if ($errorMessage !== false) {
            if (Yii::app()->request->isAjaxRequest) {
                Yii::app()->ajax->failure($errorMessage);
            } else {
                Yii::app()->user->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    $errorMessage
                );
                $this->redirect(array('/blog/blog/index'));
            }
        }

        if ($blog->userInBlog(Yii::app()->user->getId()) === false) {
            
            $blog->join(Yii::app()->user->getId());
            
            if (Yii::app()->request->isAjaxRequest) {
                Yii::app()->ajax->success(
                    array(
                        'message' => Yii::t('BlogModule.blog', 'You have joined the blog!'),
                        'content' => $this->renderPartial('_view', array('data' => $blog), true),
                    )
                );
            } else {
                Yii::app()->user->setFlash(
                    YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('BlogModule.blog', 'You have joined the blog!')
                );
                $this->redirect(array('/blog/blog/index'));
            }
        } else {
            if (Yii::app()->request->isAjaxRequest)
                Yii::app()->ajax->failure(
                    array(
                        'message' => Yii::t('BlogModule.blog', 'You already joined the blog!'),
                    )
                );
            else
            {
                Yii::app()->user->setFlash(
                    YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('BlogModule.blog', 'You already joined the blog!')
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
            if (Yii::app()->request->isAjaxRequest) {
                Yii::app()->ajax->failure(Yii::t('BlogModule.blog', 'Authorize, please!'));
            } else {
                Yii::app()->user->setFlash(
                    YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('BlogModule.blog', 'Authorize, please!')
                );
                $this->redirect(array('/blog/blog/index'));
            }
        }

        if ($blogId === null && Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest)
            $blogId = Yii::app()->request->getPost('blogId');

        $errorMessage = false;

        $blogId = (int) $blogId;
        if (!$blogId)
            $errorMessage = Yii::t('BlogModule.blog', 'blogId is not set!');

        if (($blog = Blog::model()->loadModel($blogId)) === null)
            $errorMessage = Yii::t('BlogModule.blog', 'Blog with id = {id} was not found!', array('{id}' => $blogId));
        elseif ($blog->createUser->id == Yii::app()->user->getId()) {
            if (Yii::app()->request->isAjaxRequest) {
                Yii::app()->ajax->failure(
                    Yii::t('BlogModule.blog', 'You are creator of this blog and you can\'t leave.')
                );
            } else {
                Yii::app()->user->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    Yii::t('BlogModule.blog', 'You are creator of this blog and you can\'t leave.')
                );
                $this->redirect(array('/blog/blog/index'));
            }
        }


        if ($errorMessage !== false) {
            if (Yii::app()->request->isAjaxRequest) {
                Yii::app()->ajax->failure($errorMessage);
            } else {
                Yii::app()->user->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    $errorMessage
                );
                $this->redirect(array('/blog/blog/index'));
            }
        }

        if (($userToBlog = $blog->userInBlog(Yii::app()->user->getId())) !== false) {
            
            if ($userToBlog->delete()) {
                if (Yii::app()->request->isAjaxRequest) {
                    Yii::app()->ajax->success(
                        array(
                            'message' => Yii::t('BlogModule.blog', 'You left the blog!'),
                            'content' => $this->renderPartial('_view', array('data' => $blog), true),
                        )
                    );
                } else {
                    Yii::app()->user->setFlash(
                        YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t('BlogModule.blog', 'You left the blog!')
                    );
                    $this->redirect(array('/blog/blog/index'));
                }
            } else {
                if (Yii::app()->request->isAjaxRequest) {
                    Yii::app()->ajax->failure(Yii::t('BlogModule.blog', 'An error occured when you were leaving the blog!'));
                } else {
                    Yii::app()->user->setFlash(
                        YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t('BlogModule.blog', 'An error occured when you were leaving the blog!')
                    );
                    $this->redirect(array('/blog/blog/index'));
                }
            }
        } else {
            if (Yii::app()->request->isAjaxRequest)
                Yii::app()->ajax->failure(Yii::t('BlogModule.blog', 'You are not the member of this blog!'));
            else
            {
                Yii::app()->user->setFlash(
                    YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('BlogModule.blog', 'You are not the member of this blog!')
                );
                $this->redirect(array('/blog/blog/index'));
            }
        }
    }
}