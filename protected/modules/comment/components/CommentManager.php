<?php

use yupe\models\YModel;

/**
 * Class CommentManager
 */
class CommentManager extends CApplicationComponent
{
    /**
     * @param $params
     * @param $module
     * @param $user
     * @param null $request
     * @return bool|Comment
     * @throws CException
     */
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

        /**
         * Реализована проверка прав на возможность добавления комментария в конкретную модель
         * Для того чтобы осушествить проверку у модели должен быть public метод: commitValidation()
         * Если метод вернет значение: false, то предполагается что для данной сушности добавление комментария запрещено
         **/
        $model = YModel::model($comment->model)->findByPk($comment->model_id);
        if (($model instanceof ICommentAllowed) && $model->isCommentAllowed() === false) {
            throw new CException(Yii::t('CommentModule.comment', 'Not have permission to add a comment!'));
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
                    throw new CException(Yii::t('CommentModule.comment', 'Root comment not found!'));
                }
            } else { // Иначе если parent_id не указан...

                $root = $comment->createRootOfCommentsIfNotExists($comment->model, $comment->model_id);

                if (null === $root) {
                    throw new CException(Yii::t('CommentModule.comment', 'Root comment not created!'));
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

            throw new CException(Yii::t('CommentModule.comment', 'Error append comment to root!'));

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

    /**
     * @param $model
     * @param $modelId
     * @param int $status
     * @return static[]
     */
    public function getCommentsForModel($model, $modelId, $status = Comment::STATUS_APPROVED)
    {
        return Comment::model()->with(['author'])->findAll(
            [
                'condition' => 't.model = :model AND t.model_id = :modelId AND t.status = :status AND t.lft > 1',
                'params' => [
                    ':model' => $model,
                    ':modelId' => (int)$modelId,
                    ':status' => (int)$status,
                ],
                'order' => 't.lft',
            ]
        );
    }

    /**
     * @param array $items
     * @return bool
     */
    public function multiApprove(array $items)
    {
        $transaction = Yii::app()->getDb()->beginTransaction();

        try {
            $models = Comment::model()->findAllByPk($items);

            foreach ($models as $model) {
                $model->approve();
            }

            $transaction->commit();

            return true;

        } catch (Exception $e) {
            $transaction->rollback();

            Yii::log($e->__toString(), CLogger::LEVEL_ERROR);

            return false;
        }
    }
}
