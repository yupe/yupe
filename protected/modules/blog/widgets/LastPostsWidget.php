<?php
class LastPostsWidget extends YWidget
{
    public $limit = 10;

    public function run()
    {
        $posts = Post::model()->published()->public()->cache($this->cacheTime)->findAll(array(
            'limit' => $this->limit,
            'order' => 'id DESC',
        ));

        $this->render('lastposts', array('models' =>$posts));
    }
}