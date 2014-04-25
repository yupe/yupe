<?php

use application\modules\comment\components\NewCommentEvent;

class CommentManager extends CApplicationComponent
{
    public function create($params, $module, $user)
    {
        $comment = new Comment;

        $comment->setAttributes($params);

        $comment->status = (int)$module->defaultCommentStatus;

        if ($module->autoApprove && $user->isAuthenticated()) {
            $comment->status = Comment::STATUS_APPROVED;
        }

        $transaction = Yii::app()->db->beginTransaction();

        try {

            $root = null;

            $parentId = (int)$comment->getAttribute('parent_id');

            // Если указан parent_id просто добавляем новый комментарий.
            if($parentId){

                $root = Comment::model()->approved()->findByPk($parentId);

                if(null === $root) {
                    throw new CDbException(Yii::t('CommentModule.comment','Root comment not found!'));
                }
            }
            else { // Иначе если parent_id не указан...

                $root = $comment->createRootOfCommentsIfNotExists($comment->getAttribute("model"),   $comment->getAttribute("model_id"));

                if(null === $root) {
                    throw new CDbException(Yii::t('CommentModule.comment','Root comment not created!'));
                }
            }

            if($comment->appendTo($root)){

                //events
                $event = new NewCommentEvent;
                $event->comment = $comment;
                $event->module  = $module;

                $this->onNewComment($event);

                $transaction->commit();
                // сбросить кэш
                Yii::app()->cache->delete("Comment{$comment->model}{$comment->model_id}");

                // метка для проверки спама
                Yii::app()->cache->set('Comment::Comment::spam::'.$user->getId(), time(), (int)$module->antiSpamInterval);

                return $comment;
            }

            throw new CDbException(Yii::t('CommentModule.comment','Error append comment to root!'));

        }catch (Exception $e) {

            Yii::log($e->__toString(), CLogger::LEVEL_ERROR, 'comment');

            $transaction->rollback();

            return false;
        }
    }

    public function isSpam($user)
    {
       return Yii::app()->cache->get('Comment::Comment::spam::'.$user->getId());
    }

    public function onNewComment($event)
    {
        $this->raiseEvent('onNewComment', $event);
    }
} 