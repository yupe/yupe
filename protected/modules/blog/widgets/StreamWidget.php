<?php
Yii::import('application.modules.blog.models.*');
Yii::import('application.modules.blog.BlogModule');

class StreamWidget extends YWidget
{
	public $view = 'stream';

	public $limit = 10;

	public function run()
	{
		$data = Yii::app()->cache->get('Blog::Post::Stream');

		$data = false;

		if(false === $data) {
	        $data = Yii::app()->db->createCommand()
	        ->select('p.title, p.slug, max(c.creation_date) comment_date, count(c.id) commentsCount')
	        ->from('{{comment_comment}} c')
	        ->join('{{blog_post}} p', 'c.model_id = p.id')
	           ->where('c.model = :model AND p.status = :status AND c.status = :commentstatus', array(
	           	        ':model'  => 'Post',
	           	        ':status' => Post::STATUS_PUBLISHED,
	           	        ':commentstatus' => Comment::STATUS_APPROVED
	           	 ))
		        ->group('c.model, c.model_id')
		        ->order('comment_date DESC')
	        ->having('commentsCount > 1')
	        ->limit((int)$this->limit)	        
	        ->queryAll();

	        Yii::app()->cache->set('Blog::Post::Stream', $data, $this->cacheTime);     
	    }

        $this->render($this->view, array('data' => $data));
	}
}