<?php

class CommentManager extends CApplicationComponent
{
    public function create($params, $module, $user)
    {
        if($user->isAuthenticated()) {
            $params = CMap::mergeArray(
                $params,
                array(
                    'user_id' => $user->getId(),
                    'name'    => $user->getState('nick_name'),
                    'email'   => $user->getProfileField('email'),
                )
            );
        }

        $comment = new Comment;

        $comment->setAttributes($params);

        $comment->status = (int)$module->defaultCommentStatus;

        if ($module->autoApprove && $user->isAuthenticated()) {
            $comment->status = Comment::STATUS_APPROVED;
        }

        $transaction = Yii::app()->getDb()->beginTransaction();

        Yii::app()->eventManager->fire(
            CommentEvents::BEFORE_ADD_COMMENT,
            new CommentEvent($comment, Yii::app()->getUser(), $module)
        );

        try {

            $root = null;

            $parentId = (int)$comment->parent_id;

            // Если указан parent_id просто добавляем новый комментарий.
            if ($parentId) {

                $root = Comment::model()->approved()->findByPk($parentId);

                if (null === $root) {
                    throw new CDbException(Yii::t('CommentModule.comment', 'Root comment not found!'));
                }
            } else { // Иначе если parent_id не указан...

                $root = $comment->createRootOfCommentsIfNotExists($comment->model, $comment->model_id);

                if (null === $root) {
                    throw new CDbException(Yii::t('CommentModule.comment', 'Root comment not created!'));
                }
            }

            if ($comment->appendTo($root)) {

                $transaction->commit();

                Yii::app()->eventManager->fire(
                    CommentEvents::SUCCESS_ADD_COMMENT,
                    new CommentEvent($comment, Yii::app()->getUser(), $module)
                );

                // сбросить кэш
                Yii::app()->getCache()->delete("Comment{$comment->model}{$comment->model_id}");

                // метка для проверки спама
                Yii::app()->getCache()->set(
                    'Comment::Comment::spam::' . $user->getId(),
                    time(),
                    (int)$module->antiSpamInterval
                );

                return $comment;
            }

            throw new CDbException(Yii::t('CommentModule.comment', 'Error append comment to root!'));

        } catch (Exception $e) {

            $transaction->rollback();

            Yii::app()->eventManager->fire(
                CommentEvents::ERROR_ADD_COMMENT,
                new CommentEvent($comment, Yii::app()->getUser(), $module)
            );

            Yii::log($e->__toString(), CLogger::LEVEL_ERROR, 'comment');

            return false;
        }
    }

    public function isSpam($user)
    {
        return Yii::app()->getCache()->get('Comment::Comment::spam::' . $user->getId());
    }
}
