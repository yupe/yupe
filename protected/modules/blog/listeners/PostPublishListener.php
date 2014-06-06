<?php
use Symfony\Component\EventDispatcher\Event;

class PostPublishListener
{
    public static function onPublish(Event $event)
    {
       $post = $event->getPost();
       Yii::log("Publish post {$post->title} ...", CLogger::LEVEL_TRACE);
    }
} 