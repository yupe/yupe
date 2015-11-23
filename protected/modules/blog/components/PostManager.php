<?php

/**
 * Class PostManager
 */
class PostManager extends CApplicationComponent
{
    /**
     * @param Post $post
     * @param int $limit
     * @return array|mixed|null|static[]
     */
    public function getSimilarPosts(Post $post, $limit = 10)
    {
        $criteria = new CDbCriteria();
        $criteria->limit = $limit;
        $criteria->order = 'publish_time DESC';

        $criteria->addNotInCondition('t.id', [$post->id]);

        $criteria->mergeWith(
            Post::model()->public()->published()->getFindByTagsCriteria($post->getTags())
        );

        return Post::model()->findAll(
            $criteria
        );
    }
} 
