<?php
class BlogController extends YFrontController
{
    // Выводит список блогов
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Blog', array(
            'criteria' => array(
                'condition' => 't.status = :status',
                'params' => array(':status' => Blog::STATUS_ACTIVE),
                'with' => array('createUser', 'postsCount', 'membersCount'),
                'order' => 'create_date DESC'
            ),
        ));

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    // отобразить карточку блога
    public function actionShow($slug)
    {
        $blog = Blog::model()->with(
            'createUser',
            'postsCount',
            'membersCount',
            'members'
        )->find('slug = :slug', array(':slug' => $slug));

        if(!$blog)
            throw new CHttpException(404, Yii::t('blog', 'Блог "{blog}" не найден!', array('{blog}' => $slug)));

        //получить первые 5 записей для блога
        $posts = Post::model()->published()->public()->findAll(array(
            'condition' => 'blog_id = :blog_id',
            'limit' => 5,
            'order' => 'publish_date DESC',
            'params' => array(':blog_id' => $blog->id),
        ));

        $this->render('show', array(
            'blog' => $blog,
            'posts' => $posts,
            'members' => $blog->members,
        ));
    }

    // показать участников блога 
    public function actionPeople($slug)
    {
        $blog = Blog::model()->find('slug = :slug', array(':slug' => $slug));

        if(!$blog)
            throw new CHttpException(404, Yii::t('blog', 'Блог "{blog}" не найден!', array('{blog}' => $slug)));

    }

    // "вступление" в блог
    public function actionJoin()
    {
        if(!Yii::app()->user->isAuthenticated())
        {
            if(Yii::app()->request->isAjaxRequest)
                Yii::app()->ajax->failure(Yii::t('blog', 'Пожалуйста, авторизуйтесь!'));
            else
            {
                Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('blog', 'Пожалуйста, авторизуйтесь!'));
                $this->redirect(array('/'));
            }
        }

        $errorMessage = false;

        $blogId = (int)Yii::app()->request->getPost('blogId');

        if(!$blogId)
            $errorMessage = Yii::t('blog','Не передан blogId!');

        $blog = Blog::model()->published()->public()->findByPk($blogId);

        if(!$blog)
            $errorMessage = Yii::t('blog', 'Блог с id = {id} не найден!', array('{id}' => $blogId));

        if($errorMessage)
        {
            if(Yii::app()->request->isAjaxRequest)
                Yii::app()->ajax->failure($errorMessage);
            else
            {
                Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE, $errorMessage);
                $this->redirect(array('/'));
            }
        }

        if($blog->join(Yii::app()->user->getId()))
        {
           if(Yii::app()->request->isAjaxRequest)
               Yii::app()->ajax->success(Yii::t('blog', 'Вы присоединились к блогу!'));
           else
           {
               Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('blog', 'Вы присоединились к блогу!'));
               $this->redirect(array('/blog/blog/show/', 'slug' => $blog->slug));
           }
        }
    }
}