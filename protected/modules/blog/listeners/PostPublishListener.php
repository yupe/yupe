<?php
use yupe\components\Event;

/**
 * Class PostPublishListener
 */
class PostPublishListener
{
    /**
     * @param Event $event
     */
    public static function onPublish(Event $event)
    {
        $post = $event->getPost();
        Yii::log("Publish post {$post->title} ...", CLogger::LEVEL_TRACE);
    }
}
