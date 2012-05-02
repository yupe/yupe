<?php
class PostController extends YFrontController
{
    public function actionShow($slug)
    {
        $post = Post::model()->with(
            'blog',
            'createUser'
        )->find('t.slug = :slug', array(':slug' => $slug));

        if(!$post)
            throw new CHttpException(404, Yii::t('blog', 'Запись не найдена!'));

        $this->render('show', array(
            'post' => $post,
        ));
    }
}