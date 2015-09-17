<?php

use yupe\components\Event;

/**
 * Class SitemapGeneratorListener
 */
class SitemapGeneratorListener
{
    /**
     * @param Event $event
     */
    public static function onGenerate(Event $event)
    {
        $generator = $event->getGenerator();

        $blogsProvider = new CActiveDataProvider(Blog::model()->published()->public());

        foreach (new CDataProviderIterator($blogsProvider) as $blog) {
            $generator->addItem(
                Yii::app()->createAbsoluteUrl('/blog/blog/view', ['slug' => $blog->slug]),
                $blog->update_time,
                SitemapHelper::FREQUENCY_WEEKLY,
                0.5
            );
        }

        $postProvider = new CActiveDataProvider(Post::model()->published()->public());

        foreach (new CDataProviderIterator($postProvider) as $post) {
            $generator->addItem(
                Yii::app()->createAbsoluteUrl('/blog/post/view', ['slug' => $post->slug]),
                $post->update_time,
                SitemapHelper::FREQUENCY_WEEKLY,
                0.5
            );
        }
    }
} 
