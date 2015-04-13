<?php

Yii::import('application.modules.comment.events.CommentEvent');
Yii::import('application.modules.notify.NotifyModule');
Yii::import('application.modules.blog.models.Post');
Yii::import('application.modules.blog.models.Blog');

class NotifyNewCommentListener
{
    public static function onNewComment(CommentEvent $event)
    {
        $comment = $event->getComment();

        $module = $event->getModule();

        $parent = $comment->getParent();

        //ответ на комментарий
        if ($comment->hasParent()) {

            if (null !== $parent && $parent->user_id) {

                $notify = NotifySettings::model()->getForUser($parent->user_id);

                if (null !== $notify && $notify->isNeedSendForCommentAnswer()) {

                    Yii::app()->mail->send(
                        $module->email,
                        $parent->email,
                        Yii::t(
                            'NotifyModule.notify',
                            'Reply to your comment on the website "{app}"!',
                            ['{app}' => CHtml::encode(Yii::app()->name)]
                        ),
                        Yii::app()->getController()->renderPartial(
                            'comment-reply-notify-email',
                            ['model' => $comment],
                            true
                        )
                    );
                }
            }
        }

        //нотификация автору поста
        if ('Post' === $comment->model) {

            $post = Post::model()->cache(Yii::app()->getModule('yupe')->coreCacheTime)->with(['createUser'])->get((int)$comment->model_id);

            if (null !== $post) {

                //пропускаем автора поста + если отвечают на комментарий автора поста - он уже получил уведомление выше
                if($comment->user_id != $post->create_user_id) {

                    $notify = NotifySettings::model()->getForUser($post->create_user_id);

                    if (null != $notify && $notify->isNeedSendForNewPostComment()) {

                        Yii::app()->mail->send(
                            $module->email,
                            $post->createUser->email,
                            Yii::t(
                                'NotifyModule.notify',
                                'New comment to your post on website "{app}"!',
                                ['{app}' => CHtml::encode(Yii::app()->name)]
                            ),
                            Yii::app()->getController()->renderPartial(
                                'comment-new-notify-email',
                                ['model' => $comment],
                                true
                            )
                        );
                    }
                }
            }
        }
    }
}
