<?php
class BlogController extends YFrontController
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
    public function actionShow($slug)
    {
        $blog = Blog::model()->showByUrl($slug)->with(
            array(
                'createUser',
                'postsCount',
                'membersCount',
                'members',
                'posts' => array(
                    'scopes' => array(
                        'limit' => 5,
                        'sortByPubDate' => 'DESC'
                    )
                )
            )
        )->find();

        if ($blog === null)
            throw new CHttpException(404, Yii::t('BlogModule.blog', 'Блог "{blog}" не найден!', array('{blog}' => $slug)));

        $this->render(
            'show', array(
                'blog'    => $blog,
                'posts'   => $blog->posts,
                'members' => $blog->members,
            )
        );
    }

    /**
     * Показать участников блога
     *
     * @param string $slug - url блога
     *
     * @return void
     */
    public function actionPeople($slug)
    {
        $blog = Blog::model()->published()->public()->find('slug = :slug', array(':slug' => $slug));

        if (!$blog)
            throw new CHttpException(404, Yii::t('BlogModule.blog', 'Блог "{blog}" не найден!', array('{blog}' => $slug)));

        // @TODO  Unused local variable $member
        $members = UserToBlog::model()->findAll('blog_id = :blog_id', array(':blog_id' => $blog->id));
    }

    /**
     * "вступление" в блог
     *
     * @param int $blogId - id-блога
     *
     * @return void
     */
    public function actionJoin($blogId)
    {
        if (!Yii::app()->user->isAuthenticated()) {
            if (Yii::app()->request->isAjaxRequest) {
                Yii::app()->ajax->failure(Yii::t('BlogModule.blog', 'Пожалуйста, авторизуйтесь!'));
            } else {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('BlogModule.blog', 'Пожалуйста, авторизуйтесь!')
                );
                $this->redirect(array('/'));
            }
        }

        $errorMessage = false;

        $blogId = (int) $blogId;
        if (!$blogId)
            $errorMessage = Yii::t('BlogModule.blog', 'Не передан blogId!');

        if (($blog = Blog::model()->loadModel($blogId)) === null)
            $errorMessage = Yii::t('BlogModule.blog', 'Блог с id = {id} не найден!', array('{id}' => $blogId));

        if ($errorMessage !== false) {
            if (Yii::app()->request->isAjaxRequest) {
                Yii::app()->ajax->failure($errorMessage);
            } else {
                Yii::app()->user->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    $errorMessage
                );
                $this->redirect(array('/'));
            }
        }

        if ($blog->userInBlog(Yii::app()->user->id) === false) {
            
            $blog->join(Yii::app()->user->id);
            
            if (Yii::app()->request->isAjaxRequest) {
                Yii::app()->ajax->success(Yii::t('BlogModule.blog', 'Вы присоединились к блогу!'));
            } else {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('BlogModule.blog', 'Вы присоединились к блогу!')
                );
                $this->redirect(array('/blog/blog/index'));
            }
        } else {
            if (Yii::app()->request->isAjaxRequest)
                Yii::app()->ajax->success(Yii::t('BlogModule.blog', 'Вы уже присоеденены к этому блогу!'));
            else
            {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('BlogModule.blog', 'Вы уже присоеденены к этому блогу!')
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
    public function actionUnjoin($blogId)
    {
        if (!Yii::app()->user->isAuthenticated()) {
            if (Yii::app()->request->isAjaxRequest) {
                Yii::app()->ajax->failure(Yii::t('BlogModule.blog', 'Пожалуйста, авторизуйтесь!'));
            } else {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('BlogModule.blog', 'Пожалуйста, авторизуйтесь!')
                );
                $this->redirect(array('/'));
            }
        }

        $errorMessage = false;

        $blogId = (int) $blogId;
        if (!$blogId)
            $errorMessage = Yii::t('BlogModule.blog', 'Не передан blogId!');

        if (($blog = Blog::model()->loadModel($blogId)) === null)
            $errorMessage = Yii::t('BlogModule.blog', 'Блог с id = {id} не найден!', array('{id}' => $blogId));

        if ($errorMessage !== false) {
            if (Yii::app()->request->isAjaxRequest) {
                Yii::app()->ajax->failure($errorMessage);
            } else {
                Yii::app()->user->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    $errorMessage
                );
                $this->redirect(array('/'));
            }
        }

        if (($userToBlog = $blog->userInBlog(Yii::app()->user->id)) !== false) {
            
            if ($userToBlog->delete()) {
                if (Yii::app()->request->isAjaxRequest) {
                    Yii::app()->ajax->success(Yii::t('BlogModule.blog', 'Вы покинули блог!'));
                } else {
                    Yii::app()->user->setFlash(
                        YFlashMessages::NOTICE_MESSAGE,
                        Yii::t('BlogModule.blog', 'Вы покинули блог!')
                    );
                    $this->redirect(array('/blog/blog/index'));
                }
            } else {
                if (Yii::app()->request->isAjaxRequest) {
                    Yii::app()->ajax->success(Yii::t('BlogModule.blog', 'Произошла ошибка при исключении из блога!'));
                } else {
                    Yii::app()->user->setFlash(
                        YFlashMessages::NOTICE_MESSAGE,
                        Yii::t('BlogModule.blog', 'Произошла ошибка при исключении из блога!')
                    );
                    $this->redirect(array('/blog/blog/index'));
                }
            }
        } else {
            if (Yii::app()->request->isAjaxRequest)
                Yii::app()->ajax->success(Yii::t('BlogModule.blog', 'Вы не присоеденены к этому блогу!'));
            else
            {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('BlogModule.blog', 'Вы не присоеденены к этому блогу!')
                );
                $this->redirect(array('/blog/blog/index'));
            }
        }
    }
}