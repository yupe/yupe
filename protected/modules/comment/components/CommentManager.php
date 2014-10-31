<?php

class CommentManager extends CApplicationComponent
{
    public function create($params, $module, $user, $request = null)
    {
        if ($user->isAuthenticated()) {
            $params = CMap::mergeArray(
                $params,
                [
                    'user_id' => $user->getId(),
                    'name' => $user->getState('nick_name'),
                    'email' => $user->getProfileField('email'),
                ]
            );
        }

        $comment = new Comment;

        $comment->setAttributes($params);

        $comment->status = (int)$module->defaultCommentStatus;

        if ($module->autoApprove && $user->isAuthenticated()) {
            $comment->status = Comment::STATUS_APPROVED;
        }

        $transaction = Yii::app()->getDb()->beginTransaction();

        try {

            Yii::app()->eventManager->fire(
                CommentEvents::BEFORE_ADD_COMMENT,
                new CommentEvent($comment, $user, $module, $request)
            );

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

                Yii::app()->eventManager->fire(
                    CommentEvents::SUCCESS_ADD_COMMENT,
                    new CommentEvent($comment, $user, $module)
                );

                $transaction->commit();

                return $comment;
            }

            throw new CDbException(Yii::t('CommentModule.comment', 'Error append comment to root!'));

        } catch (Exception $e) {

            $transaction->rollback();

            Yii::app()->eventManager->fire(
                CommentEvents::ERROR_ADD_COMMENT,
                new CommentEvent($comment, $user, $module)
            );

            Yii::log($e->__toString(), CLogger::LEVEL_ERROR, 'comment');

            return false;
        }
    }

    public function getCommentsForModel($model, $modelId, $status = Comment::STATUS_APPROVED)
    {
         return Comment::model()->with(['author'])->findAll(
             [
                 'condition' => 't.model = :model AND t.model_id = :modelId AND t.status = :status AND t.lft > 1',
                 'params'    => array(
                     ':model'   => $model,
                     ':modelId' => (int)$modelId,
                     ':status'  => (int)$status,
                 ),
                 'order'     => 't.lft',
             ]
         );
    }
}
