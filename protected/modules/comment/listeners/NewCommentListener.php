<?php
use yupe\components\Event;

class NewCommentListener
{
    public static function onSuccessAddComment(CommentEvent $event)
    {
        if (!Yii::app()->hasModule('mail')) {
            return false;
        }

        $body = Yii::app()->getController()->renderPartial(
            'comment-notify-email',
            ['model' => $event->getComment()],
            true
        );

        Yii::app()->mail->send(
            $event->getComment()->email,
            $event->getModule()->email,
            Yii::t(
                'CommentModule.comment',
                'New post was created on site "{app}"!',
                array('{app}' => Chtml::encode(Yii::app()->name))
            ),
            $body
        );
    }
}
