<?php
class BlogController extends YFrontController
{
	// Выводит список блогов
	public function actionIndex()
	{
        $dataProvider = new CActiveDataProvider('Blog', array(
                                                             'criteria' => array(
                                                                 'condition' => 'status = :status',
                                                                 'params' => array(':status' => Blog::STATUS_ACTIVE),
                                                                 'order' => 'create_date DESC'
                                                             )
                                                        ));

        $this->render('index', array(
                                    'dataProvider' => $dataProvider
                               ));
	}

    // отобразить карточку блога
	public function actionShow($slug)
	{
        $blog = Blog::model()->with('createUser')->find('slug = :slug',array(':slug' => $slug));

        if(!$blog)
        	throw new CHttpException(404,Yii::t('blog','Блог "{blog}" не найден!',array('{blog}' => $slug)));

        //получить первые 5 записей для блога
        $posts = Post::model()->findAll(array(
        	'condition' => 'blog_id = :blog_id',
        	'limit'     => 5,
        	'order'     => 'create_date DESC', 
        	'params'    => array(':blog_id' => $blog->id)
        ));
        
        $this->render('show',array('blog' => $blog, 'posts' => $posts));
	}
    
    // показать участников блога 
	public function actionPeople($slug)
	{
       
	}
}