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
    public function actionShow($slug = null)
    {
        if ($slug !== null && ($blogID = Yii::app()->request->getPost('blogID')) == null) {
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
        } else {
            if (!Yii::app()->request->isPostRequest
                || !Yii::app()->request->isAjaxRequest
                || ($blog = Blog::model()->with(
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
                )->findByPk($blogID)) == null
            )
                throw new CHttpException(404, Yii::t('BlogModule.blog', 'Страница не найдена!'));

            Yii::app()->ajax->success(
                $this->renderPartial('_post_list', array('posts' => $blog->posts), true)
            );
        }

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
     * @return void
     */
    public function actionPeople()
    {
        if (!Yii::app()->request->isPostRequest || !Yii::app()->request->isAjaxRequest)
            throw new CHttpException(404, Yii::t('BlogModule.blog', 'Страница не найдена!'));

        if (($blog = Blog::model()->loadModel(($blogId = Yii::app()->request->getPost('blogId')))) === null)
            Yii::app()->ajax->failure(
                Yii::t('BlogModule.blog', 'Блог #{blog} не найден!', array('{blog}' => $blogId))
            );

        if (count($members = $blog->members) < 1)
            Yii::app()->ajax->failure(
                Yii::t('BlogModule.blog', 'В данном блоге ещё нет участников!')
            );
        else
            Yii::app()->ajax->success(
                $this->renderPartial('_people', array('members' => $members), true)
            );
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
        if ($blogId === null && Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest)
            $blogId = Yii::app()->request->getPost('blogId');

        if (!Yii::app()->user->isAuthenticated()) {
            if (Yii::app()->request->isAjaxRequest) {
                Yii::app()->ajax->failure(Yii::t('BlogModule.blog', 'Пожалуйста, авторизуйтесь!'));
            } else {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('BlogModule.blog', 'Пожалуйста, авторизуйтесь!')
                );
                $this->redirect(array('/blog/blog/index'));
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
                Yii::app()->ajax->success(
                    array(
                        'message' => Yii::t('BlogModule.blog', 'Вы присоединились к блогу!'),
                        'content' => $this->renderPartial('_view', array('data' => $blog), true),
                    )
                );
            } else {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('BlogModule.blog', 'Вы присоединились к блогу!')
                );
                $this->redirect(array('/blog/blog/index'));
            }
        } else {
            if (Yii::app()->request->isAjaxRequest)
                Yii::app()->ajax->failure(
                    array(
                        'message' => Yii::t('BlogModule.blog', 'Вы уже присоединились к блогу!'),
                    )
                );
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
    public function actionUnjoin($blogId = null)
    {
        if ($blogId === null && Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest)
            $blogId = Yii::app()->request->getPost('blogId');

        if (!Yii::app()->user->isAuthenticated()) {
            if (Yii::app()->request->isAjaxRequest) {
                Yii::app()->ajax->failure(Yii::t('BlogModule.blog', 'Пожалуйста, авторизуйтесь!'));
            } else {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('BlogModule.blog', 'Пожалуйста, авторизуйтесь!')
                );
                $this->redirect(array('/blog/blog/index'));
            }
        }

        $errorMessage = false;

        $blogId = (int) $blogId;
        if (!$blogId)
            $errorMessage = Yii::t('BlogModule.blog', 'Не передан blogId!');

        if (($blog = Blog::model()->loadModel($blogId)) === null)
            $errorMessage = Yii::t('BlogModule.blog', 'Блог с id = {id} не найден!', array('{id}' => $blogId));
        elseif ($blog->createUser->id == Yii::app()->user->id) {
            if (Yii::app()->request->isAjaxRequest) {
                Yii::app()->ajax->failure(
                    Yii::t('BlogModule.blog', 'Вы являетесь создателем данного блога и не можете его покинуть.')
                );
            } else {
                Yii::app()->user->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    Yii::t('BlogModule.blog', 'Вы являетесь создателем данного блога и не можете его покинуть.')
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
                $this->redirect(array('/'));
            }
        }

        if (($userToBlog = $blog->userInBlog(Yii::app()->user->id)) !== false) {
            
            if ($userToBlog->delete()) {
                if (Yii::app()->request->isAjaxRequest) {
                    Yii::app()->ajax->success(
                        array(
                            'message' => Yii::t('BlogModule.blog', 'Вы покинули блог!'),
                            'content' => $this->renderPartial('_view', array('data' => $blog), true),
                        )
                    );
                } else {
                    Yii::app()->user->setFlash(
                        YFlashMessages::NOTICE_MESSAGE,
                        Yii::t('BlogModule.blog', 'Вы покинули блог!')
                    );
                    $this->redirect(array('/blog/blog/index'));
                }
            } else {
                if (Yii::app()->request->isAjaxRequest) {
                    Yii::app()->ajax->failure(Yii::t('BlogModule.blog', 'Произошла ошибка при исключении из блога!'));
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
                Yii::app()->ajax->failure(Yii::t('BlogModule.blog', 'Вы не присоеденены к этому блогу!'));
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