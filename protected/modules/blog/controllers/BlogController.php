<?php
class BlogController extends YFrontController
{
	// Выводит список блогов
	public function actionIndex()
	{

	}

    // отобразить карточку блога
	public function actionShow($slug)
	{
        $blog = Blog::model()->with('createUser')->find('slug = :slug',array(':slug' => $slug));

        if(!$blog)
        	throw new CHttpException(404,Yii::t('blog','Блог "{blog}" не найден!',array('{blog}' => $slug)));
        
        $this->render('show',array('blog' => $blog));
	}
}