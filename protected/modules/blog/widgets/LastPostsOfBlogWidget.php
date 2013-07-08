<?php
class LastPostsOfBlogWidget extends YWidget
{
    public $limit = 5;

    public $blogId;

    public function run()
    {
        $posts = Post::model()->public()->published()->findAll(array(
                'condition' => 'blog_id = :blog_id',
                'limit'  => (int)$this->limit,
                'order'  => 'publish_date DESC',
                'params' => array(
                    ':blog_id' => (int)$this->blogId
                )
        ));

        $this->render('lastpostsofblog', array('posts' => $posts));
    }
}