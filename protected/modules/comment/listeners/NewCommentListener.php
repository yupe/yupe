<?php

class NewCommentListener
{
    public static function onAfterSaveComment(CommentEvent $event)
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
            Yii::log(sprintf('Comment spam (js) by user_d = "%s" ', $event->getUser()->getId()), CLogger::LEVEL_ERROR);
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

        if (!Yii::app()->hasModule('mail')) {
            return false;
        }

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

        return Yii::app()->mail->send(
            $comment->email,
            $module->email,
            Yii::t(
                'CommentModule.comment',
                'New post was created on site "{app}"!',
                array('{app}' => Chtml::encode(Yii::app()->name))
            ),
            Yii::app()->getController()->renderPartial(
                'comment-notify-email',
                ['model' => $event->getComment()],
                true
            )
        );
    }
}
