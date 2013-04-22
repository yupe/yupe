<?php
class LastPostsOfBlogWidget extends YWidget
{
    public $limit = 10;
    public $blogID;

    public function run()
    {
        $blog = Blog::model()->with(
            array(
                'posts' => array(
                    'scopes' => array(
                        'limit'         => $this->limit,
                        'sortByPubDate' => 'DESC'
                    )
                )
            )
        )->findByPk($this->blogID);

        $this->render('lastpostsofblog', array('model' => $blog));
    }
}