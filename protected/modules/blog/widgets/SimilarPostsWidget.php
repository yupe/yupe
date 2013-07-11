<?php
class SimilarPostsWidget extends YWidget
{
    public $limit = 10;
    public $post;

    public function run()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = $this->limit;
        $criteria->order = 'publish_date DESC';

        $criteria->addNotInCondition('t.id', array($this->post->id));

        $criteria->mergeWith(
            Post::model()->getFindByTagsCriteria($this->post->getTags())
        );
        
        $posts = Post::model()->findAll(
            $criteria
        );

        $this->render('similarposts', array('posts' => $posts));
    }
}