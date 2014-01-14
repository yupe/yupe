<?php

/**
 * Comment controller class
 * Класс для обработки комментариев на фронт-части.
 *
 * @tutorial для ajax-варианта добавления комментария:
 *            $.ajax({
 *                type: 'post',
 *                url: $(<comment_form>).attr('action'),
 *                data: $(<comment_form>).serialize(),
 *                success: function(data) {
 *                    // Обработка нормального состояния
 *                },
 *                error: function(data) {
 *                    // Обработка ошибки
 *                },
 *                dataType: 'json'
 *            });
 * @return   для ajax-варианта добавления комментария:
 *              {
 *                  "result": <result>,                                 // boolean
 *                  "data": {
 *                      "message": "<сообщение>",                       // string
 *                      "comment": {
 *                          "parent_id": <parent_id>                    // int
 *                      },
 *                      "commentContent": "<отрисованный комментарий>"  // string
 *                  }
 *              }
 *
 * @category YupeControllers
 * @package  yupe.modules.comment.controllers
 * @author   Yupe Team <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 *
 **/

class CommentController extends yupe\components\controllers\FrontController
{
    /**
     * Объявляем действия:
     *
     * @return mixed actions
     **/
    public function actions()
    {
        return array(
            'captcha' => array(
                'class'     => 'yupe\components\actions\YCaptchaAction',
                'backColor' => 0xFFFFFF,
                'testLimit' => 1
            ),
        );
    }

    /**
     * Action добавления комментария
     *
     *
     **/
    public function actionAdd()
    {
        if(!Yii::app()->getRequest()->getIsPostRequest() || !Yii::app()->getRequest()->getPost('Comment')){
            throw new CHttpException(404);
        }

        $module = Yii::app()->getModule('comment');

        if(!$module->allowGuestComment && !Yii::app()->user->isAuthenticated()) {
            throw new CHttpException(404);
        }      

        $comment = new Comment;

        $comment->setAttributes(
            Yii::app()->getRequest()->getPost('Comment')
        );
       
        $comment->status = (int)$module->defaultCommentStatus;

        if (Yii::app()->user->isAuthenticated()) {
            $comment->setAttributes(
                array(
                    'user_id' => Yii::app()->user->getId(),
                    'name'    => Yii::app()->user->getState('nick_name'),
                    'email'   => Yii::app()->user->getState('email'),
                )
            );

            if ($module->autoApprove) {
                $comment->status = Comment::STATUS_APPROVED;
            }
        }

        $saveStatus = false;
        $parentId = $comment->getAttribute('parent_id');
        $message = Yii::t('CommentModule.comment', 'Record was not added! Fill form correct!');
        $antiSpamTime = $module->antispamInterval;

        $itIsSpamMessage = Comment::isItSpam(
            $comment,
            Yii::app()->user->getId(),
            $antiSpamTime
        );

        if($itIsSpamMessage) {
            $message = Yii::t(
                'CommentModule.comment',
                'Spam protection, try to create comment after {few} seconds!',
                array('{few}' => $antiSpamTime)
            );
        }else{

            // Если указан parent_id просто добавляем новый комментарий.
            if($parentId > 0)
            {
                $rootForComment = Comment::model()->findByPk($parentId);
                $saveStatus = $comment->appendTo($rootForComment);
            }
            else
            { // Иначе если parent_id не указан...

                $rootNode = Comment::createRootOfCommentsIfNotExists($comment->getAttribute("model"),
                    $comment->getAttribute("model_id"));

                // Добавляем комментарий к корню.
                if ($rootNode !== false && $rootNode->id > 0)
                {
                    $saveStatus = $comment->appendTo($rootNode);
                }
            }
        }

        if ($saveStatus) {

            $redirect = Yii::app()->getRequest()->getPost('redirectTo', Yii::app()->user->returnUrl);

            // сбросить кэш
            Yii::app()->cache->delete("Comment{$comment->model}{$comment->model_id}");

            $message = $comment->status !== Comment::STATUS_APPROVED
                ? Yii::t('CommentModule.comment', 'You comments is in validation. Thanks.')
                : Yii::t('CommentModule.comment', 'You record was created. Thanks.');

            $commentContent = $comment->status !== Comment::STATUS_APPROVED
                ? ''
                : $this->_renderComment($comment);

            if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                Yii::app()->ajax->success(
                    array(
                        'message'        => $message,
                        'comment'        => array(
                            'parent_id'  => $comment->parent_id
                        ),
                        'commentContent' => $commentContent
                    )
                );
            }

            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                $message
            );

            $this->redirect($redirect);

        } else {

            if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                Yii::app()->ajax->failure(
                    array(
                        'message' => $message                        
                    )
                );
            }

            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::ERROR_MESSAGE, $message
            );
            
            $this->redirect($redirect);
        }
    }

    /**
     * Отрисовка комментария:
     *
     * @param Comment $comment - комментарий
     *
     * @return string html отрисованного комментария
     **/
    private function _renderComment(Comment $comment)
    {
        $comment->refresh();

        return $this->renderPartial('_comment', array('comment' => $comment, 'level' => $comment->getLevel()), true);
    }
}