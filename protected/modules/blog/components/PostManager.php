<?php

class PostManager extends CApplicationComponent
{
    public function getSimilarPosts(Post $post, $limit = 10)
    {
        $criteria = new CDbCriteria();
        $criteria->limit = $limit;
        $criteria->order = 'publish_date DESC';

        $criteria->addNotInCondition('t.id', [$post->id]);

        $criteria->mergeWith(
            Post::model()->public()->published()->getFindByTagsCriteria($post->getTags())
        );

        return Post::model()->findAll(
            $criteria
        );
    }
} 
