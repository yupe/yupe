<?php
class DefaultController extends YFrontController
{
    // Выводит список блогов
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Blog', array(
            'criteria' => array(
                'condition' => 't.status = :status',
                'params'    => array(':status' => Blog::STATUS_ACTIVE),
                'with'      => array('createUser', 'postsCount', 'membersCount'),
                'order'     => 'create_date DESC',
            ),
        ));
        $this->render('index', array('dataProvider' => $dataProvider));
    }

    // Отобразить карточку блога
    public function actionShow($slug)
    {    	
        $blog = Blog::model()->with(
            'createUser',
            'postsCount',
            'membersCount',
            'members'
        )->find('slug = :slug', array(':slug' => $slug));

        if (!$blog)
            throw new CHttpException(404, Yii::t('BlogModule.blog', 'Блог "{blog}" не найден!', array('{blog}' => $slug)));

        // Получить первые 5 записей для блога
        $posts = Post::model()->published()->public()->findAll(array(
            'condition' => 'blog_id = :blog_id',
            'limit'     => 5,
            'order'     => 'publish_date DESC',
            'params'    => array(':blog_id' => $blog->id),
        ));

        $this->render('show', array(
            'blog'    => $blog,
            'posts'   => $posts,
            'members' => $blog->members,
        ));
    }

    // Показать участников блога 
    public function actionPeople($slug)
    {
        $blog = Blog::model()->published()->public()->find('slug = :slug', array(':slug' => $slug));

        if (!$blog)
            throw new CHttpException(404, Yii::t('BlogModule.blog', 'Блог "{blog}" не найден!', array('{blog}' => $slug)));

        $members = UserToBlog::model()->findAll('blog_id = :blog_id', array(':blog_id' => $blog->id));
    }

    // Отобразить записи конкретного блога
    public function actionPosts($slug)
    {
        // @TODO реализовать в 0.5
    }

    // "вступление" в блог
    public function actionJoin($blogId)
    {
        if (!Yii::app()->user->isAuthenticated())
        {
            if (Yii::app()->request->isAjaxRequest)
                Yii::app()->ajax->failure(Yii::t('BlogModule.blog', 'Пожалуйста, авторизуйтесь!'));
            else
            {
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

        $blog = Blog::model()->findByPk($blogId);
        
        if (!$blog)
            $errorMessage = Yii::t('BlogModule.blog', 'Блог с id = {id} не найден!', array('{id}' => $blogId));

        if ($errorMessage)
        {
            if (Yii::app()->request->isAjaxRequest)
                Yii::app()->ajax->failure($errorMessage);
            else
            {
                Yii::app()->user->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    $errorMessage
                );
                $this->redirect(array('/'));
            }
        }

        if ($blog->join(Yii::app()->user->id))
        {
            if (Yii::app()->request->isAjaxRequest)
                Yii::app()->ajax->success(Yii::t('BlogModule.blog', 'Вы присоединились к блогу "{slug}"!', array('{slug}' => $blog->slug)));
            else
            {
               Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('BlogModule.blog', 'Вы присоединились к блогу "{slug}"!', array('{slug}' => $blog->slug))
               );
               $this->redirect(array('/blog/default/index'));
            }
        }
        else
        {
            if (Yii::app()->request->isAjaxRequest)
                Yii::app()->ajax->success(Yii::t('BlogModule.blog', 'Вы уже присоеденены к этому блогу "{slug}"!', array('{slug}' => $blog->slug)));
            else
            {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('BlogModule.blog', 'Вы уже присоеденены к этому блогу "{slug}"!', array('{slug}' => $blog->slug))
                );
                $this->redirect(array('/blog/default/index'));
            }
        }
    }
}