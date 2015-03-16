<?php

class NewCommentListener
{
    public static function onAfterSaveComment(CommentEvent $event)
    {
        if ($cache = Yii::app()->getCache()) {
            $cache->delete("Comment{$event->getComment()->model}{$event->getComment()->model_id}");
        }
    }

    public static function onAfterDeleteComment(CommentEvent $event)
    {
        if ($cache = Yii::app()->getCache()) {
            $cache->delete("Comment{$event->getComment()->model}{$event->getComment()->model_id}");
        }
    }

    public static function onBeforeAddComment(CommentEvent $event)
    {
        // проверка на таймаут добавления нового комментария
        if (false !== Yii::app()->getCache()->get('Comment::Comment::spam::' . $event->getUser()->getId())) {
            Yii::log(sprintf('Comment timeout by user_d = "%s" ', $event->getUser()->getId()), CLogger::LEVEL_ERROR);
            throw new CException('Comment timeout !');
        }

        //проверка на спам
        $spamField = $event->getUser()->getState('spamField');

        if(null === $event->getRequest()->getPost($spamField) || $event->getRequest()->getPost($spamField) != $event->getUser()->getState('spamFieldValue')) {
            Yii::log(sprintf('Comment spam (js) by user_d = "%s" Wait for %s but get %s', $event->getUser()->getId(), $event->getUser()->getState('spamFieldValue'), $event->getRequest()->getPost($spamField)), CLogger::LEVEL_ERROR);
            throw new CException('Spam !');
        }

        if($event->getComment()->comment) {
            Yii::log(sprintf('Comment spam (comment) by user_d = "%s" ', $event->getUser()->getId()), CLogger::LEVEL_ERROR);
            throw new CException('Spam !');
        }
    }

    public static function onSuccessAddComment(CommentEvent $event)
    {
        $user = $event->getUser();

        Yii::log(sprintf('Success add comment by user_id =  "%s" ', $user->getId()), CLogger::LEVEL_INFO);

        $comment = $event->getComment();

        $module = $event->getModule();

        // сбросить кэш
        Yii::app()->getCache()->delete("Comment{$comment->model}{$comment->model_id}");

        // метка для проверки спама
        Yii::app()->getCache()->set(
            'Comment::Comment::spam::' . $user->getId(),
            time(),
            (int)$module->antiSpamInterval
        );
    }
}
