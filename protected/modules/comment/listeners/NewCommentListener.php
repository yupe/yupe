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
        if (false !== Yii::app()->getCache()->get('Comment::Comment::spam::' . $event->getUser()->getId())) {
            Yii::log(sprintf('Comment timeout by user "%s" ', $event->getUser()->nick_name), CLogger::LEVEL_ERROR);
            throw new CException('Comment timeout!');
        }
    }

    public static function onSuccessAddComment(CommentEvent $event)
    {
        if (!Yii::app()->hasModule('mail')) {
            return false;
        }

        $comment = $event->getComment();

        $module = $event->getModule();

        $user = $event->getUser();

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
