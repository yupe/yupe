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
 * @version  0.7
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
                'class' => 'yupe\components\actions\YCaptchaAction',
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
        if (!Yii::app()->getRequest()->getIsPostRequest() || !Yii::app()->getRequest()->getPost('Comment')) {
            throw new CHttpException(404);
        }

        $module = Yii::app()->getModule('comment');

        if (!$module->allowGuestComment && !Yii::app()->getUser()->isAuthenticated()) {
            throw new CHttpException(404);
        }

        if (Yii::app()->commentManager->isSpam(Yii::app()->user)) {

            if (Yii::app()->getRequest()->getIsAjaxRequest()) {

                Yii::app()->ajax->failure(
                    array(
                        'message' => Yii::t(
                                'CommentModule.comment',
                                'Spam protection, try to create comment after {few} seconds!',
                                array(
                                    '{few}' => $module->antiSpamInterval
                                )
                            )
                    )
                );
            }

            throw new CHttpException(404, Yii::t(
                'CommentModule.comment',
                'Spam protection, try to create comment after {few} seconds!',
                array(
                    '{few}' => $module->antiSpamInterval
                )
            ));
        }

        $params = Yii::app()->getRequest()->getPost('Comment');

        if (Yii::app()->getUser()->isAuthenticated()) {

            $params = CMap::mergeArray(
                $params,
                array(
                    'user_id' => Yii::app()->getUser()->getId(),
                    'name' => Yii::app()->getUser()->getState('nick_name'),
                    'email' => Yii::app()->getUser()->getProfileField('email'),
                )
            );
        }

        $redirect = Yii::app()->getRequest()->getPost('redirectTo', Yii::app()->getUser()->returnUrl);

        try
        {
            if (($comment = Yii::app()->commentManager->create($params, $module, Yii::app()->getUser()))) {

                $commentContent = $comment->status == Comment::STATUS_APPROVED ? $this->_renderComment($comment) : '';

                if (Yii::app()->getRequest()->getIsAjaxRequest()) {

                    Yii::app()->ajax->success(
                        array(
                            'message' => Yii::t('CommentModule.comment', 'You record was created. Thanks.'),
                            'comment' => array(
                                'parent_id' => $comment->parent_id
                            ),
                            'commentContent' => $commentContent
                        )
                    );
                }

                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('CommentModule.comment', 'You record was created. Thanks.')
                );

                $this->redirect($redirect);

            } else {

                if (Yii::app()->getRequest()->getIsAjaxRequest()) {

                    Yii::app()->ajax->failure(
                        array(
                            'message' => Yii::t('CommentModule.comment', 'Record was not added! Fill form correct!')
                        )
                    );
                }

                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    Yii::t('CommentModule.comment', 'Record was not added! Fill form correct!')
                );

                $this->redirect($redirect);
            }
        }
        catch(Exception $e)
        {
            if (Yii::app()->getRequest()->getIsAjaxRequest()) {

                Yii::app()->ajax->failure(
                    array(
                        'message' => Yii::t('CommentModule.comment', 'Record was not added! Fill form correct!')
                    )
                );
            }

            Yii::app()->getUser()->setFlash(
                yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                Yii::t('CommentModule.comment', 'Record was not added! Fill form correct!')
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