<?php
class LastPostsWidget extends YWidget
{
    public $limit = 5;

    public $view = 'lastposts';

    public function run()
    {
        $posts = Post::model()->published()->public()->cache($this->cacheTime)->findAll(array(
            'limit' => $this->limit,
            'order' => 'id DESC',
        ));

        $this->render($this->view, array('models' =>$posts));
    }
}