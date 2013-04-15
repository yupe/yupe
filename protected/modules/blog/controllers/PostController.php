<?php
class PostController extends YFrontController
{
    public function actionShow($slug)
    {
        $post = Post::model()->with('blog','createUser','comments.author')->find('t.slug = :slug', array(
            ':slug' => $slug
        ));

        if (null === $post)
            throw new CHttpException(404, Yii::t('BlogModule.blog', 'Запись не найдена!'));

        $this->render('show', array('post' => $post));
    }

    public function actionList($tag)
    {
        $tag = CHtml::encode($tag);

        $posts = Post::model()->with(
            'blog',
            'createUser'
        )->published()->public()->taggedWith($tag)->findAll();

        $this->render('list', array(
                'posts' => $posts,
                'tag'   => $tag,
            ));
    }
}