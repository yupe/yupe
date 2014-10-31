<?php

Yii::import('application.modules.comment.events.CommentEvent');
Yii::import('application.modules.notify.NotifyModule');

class NotifyNewCommentListener
{
    public static function onNewComment(CommentEvent $event)
    {
        $comment = $event->getComment();

        $module = $event->getModule();

        //ответ на комментарий
        if($comment->hasParent()) {

            $parent = $comment->getParent();

            if(null !== $parent && $parent->user_id) {

                $notify = NotifySettings::model()->getForUser($parent->user_id);

                if(null !== $notify && $notify->isNeedSendForCommentAnswer()) {

                    return Yii::app()->mail->send(
                        $comment->email,
                        $module->email,
                        Yii::t(
                            'NotifyModule.notify',
                            'Reply to your comment on the website "{app}"!',
                            array('{app}' => Chtml::encode(Yii::app()->name))
                        ),
                        Yii::app()->getController()->renderPartial(
                            'comment-reply-notify-email',
                            ['model' => $event->getComment()],
                            true
                        )
                    );
                }
            }
        }

        //нотификация автору поста



    }
}
