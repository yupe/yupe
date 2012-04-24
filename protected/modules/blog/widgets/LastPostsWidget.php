<?php
class LastPostsWidget extends YWidget
{
	public $limit = 10;

	public function run()
	{
		$posts = Post::model()->published()->public()->findAll(array(
			'limit' => $this->limit
		));

		$this->render('lastposts',array('posts' => $posts));
	}
}