<?php

/**
 * PostController контроллер для постов на публичной части сайта
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.blog.controllers
 * @since 0.1
 *
 */
class PostController extends \yupe\components\controllers\FrontController
{

    public function actionIndex()
    {
        $this->render('index', ['model' => Post::model()]);
    }

    /**
     * Показываем пост по урлу
     *
     * @param  string $slug - урл поста
     * @throws CHttpException
     * @return void
     */
    public function actionView($slug)
    {
        $post = Post::model()->get($slug, ['blog', 'createUser', 'comments.author']);

        if (null === $post) {
            throw new CHttpException(404, Yii::t('BlogModule.blog', 'Post was not found!'));
        }

        $this->render('view', ['post' => $post]);
    }

    /**
     * Показываем посты по тегу
     *
     * @param  string $tag - Tag поста
     * @throws CHttpException
     * @return void
     */
    public function actionTag($tag)
    {
        $tag = CHtml::encode($tag);

        $posts = Post::model()->getByTag($tag);

        if (empty($posts)) {
            throw new CHttpException(404, Yii::t('BlogModule.blog', 'Posts not found!'));
        }

        $this->render('tag', ['posts' => $posts, 'tag' => $tag]);
    }

    public function actionBlog($slug)
    {
        $blog = Blog::model()->getByUrl($slug)->find();

        if (null === $blog) {
            throw new CHttpException(404);
        }

        $this->render('blog-post', ['target' => $blog, 'posts' => $blog->getPosts()]);
    }

    public function actionCategory($slug)
    {
        $category = Category::model()->getByAlias($slug);

        if (null === $category) {
            throw new CHttpException(404, Yii::t('BlogModule.blog', 'Page was not found!'));
        }

        $this->render(
            'category-post',
            ['target' => $category, 'posts' => Post::model()->getForCategory($category->id)]
        );
    }

    public function actionCategories()
    {
        $this->render('categories', ['categories' => Post::model()->getCategories()]);
    }
}
