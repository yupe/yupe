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
class PostController extends YFrontController
{
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
            throw new CHttpException(404, Yii::t('BlogModule.blog', 'Запись не найдена!'));
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
            throw new CHttpException(404, Yii::t('BlogModule.blog', 'Страница не найдена!'));
        }

        $posts = new Post('search');
        $posts->unsetAttributes();
        $posts->category_id = $category->id;

        $this->render('blog-post',array('target' => $category,'posts' => $posts));
    }

    /**
     * Обновляем список постов:
     * 
     * @return void
     */
    public function actionUpdatecomments()
    {
        if (!Yii::app()->request->isPostRequest || !Yii::app()->request->isAjaxRequest)
            throw new CHttpException(404, Yii::t('BlogModule.blog', 'Страница не найдена!'));
        
        if (($postId = Yii::app()->request->getPost('postID')) === null || ($post = Post::model()->loadModel($postId)) === null)
            Yii::app()->ajax->failure(
                Yii::t(
                    'BlogModule.blog', 'Запись #{postID} не найдена!', array(
                        '{postID}' => $postId
                    )
                )
            );

        Yii::app()->ajax->success(
            array(
                'message' => Yii::t(
                    'BlogModule.blog', 'Комментарии записи #{postID} успешно обновлены!', array(
                        '{postID}' => $postId
                    )
                ),
                'content' => $this->widget(
                    'application.modules.comment.widgets.CommentsListWidget', array(
                            'model' => $post,
                            'modelId'  => $post->id,
                            'comments' => $post->comments
                    ), true
                )
            )
        );
    }
}