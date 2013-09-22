<?php
/**
 * Класс контроллера Post, для работы с постами блогов:
 *
 * @category YupeController
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.1
 * @link     http://yupe.ru
 *
 **/
class PostController extends yupe\components\controllers\FrontController
{

    public function actionIndex()
    {
        $posts = Post::model()->with('blog','createUser')->published()->public()->findAll(array(
                'order' => 'publish_date DESC'
            ));

        $this->render('index', array('posts' => $posts));
    }

    /**
     * Показываем пост по урлу
     * 
     * @param string $slug - урл поста
     * 
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

        $posts = Post::model()->with(
            'blog',
            'createUser'
        )->published()->public()->taggedWith($tag)->findAll();

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