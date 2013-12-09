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
class PostController extends yupe\components\controllers\FrontController
{

    public function actionIndex()
    {
        $posts = Post::model();

        $this->render('index', array('model' => $posts));
    }

    /**
     * Показываем пост по урлу
     * 
     * @param string $slug - урл поста
     * @throws CHttpException
     * @return void
     */
    public function actionShow($slug)
    {
        $post = Post::model()->with(
            'blog', 'createUser', 'comments.author'
        )->find(
            't.slug = :slug', array(
                ':slug' => $slug
            )
        );

        if (null === $post){
            throw new CHttpException(404, Yii::t('BlogModule.blog', 'Post was not found!'));
        }

        $this->render('show', array('post' => $post));
    }

    /**
     * Показываем посты по тегу
     * 
     * @param string $tag - Tag поста
     * 
     * @return void
     */
    public function actionList($tag)
    {
        $tag = CHtml::encode($tag);

        $criteria = new CDbCriteria;
        $criteria->order = 'publish_date DESC';

        $posts = Post::model()->with(
            'blog',
            'createUser'
        )->published()
         ->public()
         ->taggedWith($tag)
         ->findAll($criteria);

        $this->render(
            'list', array(
                'posts' => $posts,
                'tag'   => $tag,
            )
        );
    }

    public function actionBlog($slug)
    {
        $blog = Blog::model()->getByUrl($slug)->find();

        if(null === $blog){
            throw new CHttpException(404);
        }

        $posts = new Post('search');
        $posts->unsetAttributes();
        $posts->blog_id = $blog->id;
        $posts->status  = Post::STATUS_PUBLISHED;
        $posts->access_type = Post::ACCESS_PUBLIC;

        $this->render('blog-post',array('target' => $blog,'posts' => $posts));
    }


    public function actionCategory($alias)
    {
        $category = Category::model()->cache($this->yupe->coreCacheTime)->find('alias = :alias',array(
                ':alias' => $alias
            ));

        if(null === $category){
            throw new CHttpException(404, Yii::t('BlogModule.blog', 'Page was not found!'));
        }

        $posts = new Post('search');
        $posts->unsetAttributes();
        $posts->category_id = $category->id;

        $this->render('blog-post',array('target' => $category,'posts' => $posts));
    }
}