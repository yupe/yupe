<?php
/**
 * File of Comment controller class:
 *
 * @category YupeControllers
 * @package  YupeCMS
 * @author   Yupe Team <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 *
 **/

/**
 * Comment controller class:
 * Класс для обработки комментариев на фронт-части.
 *
 * @method public actions         - Описание существующих импортируемых экшенов
 * @method public actionAdd       - Добавление комментария из фронт-части
 * @method private _renderComment - Рендеринг одного комментария (для ajax-метода)
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
 * @package  YupeCMS
 * @author   Yupe Team <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 *
 **/
class CommentController extends YFrontController
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
                'class'     => 'application.modules.yupe.components.actions.YCaptchaAction',
                'backColor' => 0xFFFFFF,
                'testLimit' => 1
            ),
        );
    }

    /**
     * Action добавления комментария:
     *
     * @return nothing
     **/
    public function actionAdd()
    {
        if(!Yii::app()->request->isPostRequest || !Yii::app()->request->getPost('Comment')){
            throw new CHttpException(404);
        }

        $redirect = Yii::app()->request->getPost('redirectTo', Yii::app()->user->returnUrl);

        $comment = new Comment;
        $comment->setAttributes(
            Yii::app()->request->getPost('Comment')
        );

        $module = Yii::app()->getModule('comment');
        $comment->status = $module->defaultCommentStatus;

        if (Yii::app()->user->isAuthenticated()) {
            $userAttributes = array(
                'user_id' => Yii::app()->user->getId(),
                'name'    => Yii::app()->user->getState('nick_name'),
                'email'   => Yii::app()->user->getState('email'),
            );

            $comment->setAttributes($userAttributes);
            if ($module->autoApprove)
                $comment->status = Comment::STATUS_APPROVED;
        }

        $saveStatus = false;
        $parentId = $comment->getAttribute('parent_id');
        if($parentId > 0)
        {
            $rootForComment = Comment::model()->findByPk($parentId);
            $saveStatus = $comment->appendTo($rootForComment);
        }else{
            $rootNode = Comment::model()->findByAttributes(
                array(
                    "model" => $comment->getAttribute("model"),
                    "model_id" => $comment->getAttribute("model_id"),
                ),
                "id=root"
            );

            if ($rootNode === null) {
                $rootAttributes = array(
                    "user_id" => Yii::app()->user->getId(),
                    "model" => $comment->getAttribute("model"),
                    "model_id" => $comment->getAttribute("model_id"),
                    "url" => "",
                    "name" => "",
                    "email" => "",
                    "text" => "",
                    "status" => Comment::STATUS_APPROVED,
                    "ip" => ""
                );

                $rootNode = new Comment();
                $rootNode->setAttributes($rootAttributes);
                $rootNode->saveNode(false);
            }
            if ($rootNode->id > 0) {
                $saveStatus = $comment->appendTo($rootNode);
            }
        }

        if ($saveStatus) {

            // сбросить кэш
            Yii::app()->cache->delete("Comment{$comment->model}{$comment->model_id}");

            // если нужно уведомить администратора - уведомляем =)
            if ($module->notify && ($notifier = new Notifier()) !== false) {
                $comment->onNewComment = array($notifier, 'newComment');
                $comment->newComment();
            }

            $message = $comment->status !== Comment::STATUS_APPROVED
                ? Yii::t('CommentModule.comment', 'Спасибо, Ваша запись добавлена и ожидает проверки!')
                : Yii::t('CommentModule.comment', 'Спасибо, Ваша запись добавлена!');

            $commentContent = $comment->status !== Comment::STATUS_APPROVED
                ? ''
                : $this->_renderComment($comment);

            if (Yii::app()->request->isAjaxRequest) {
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
                YFlashMessages::SUCCESS_MESSAGE,
                $message
            );

            $this->redirect($redirect);

        } else {
            $message = Yii::t('CommentModule.comment', 'Запись не добавлена! Заполните форму корректно!');

            if (Yii::app()->request->isAjaxRequest) {
                Yii::app()->ajax->failure(
                    array(
                        'message' => $message
                    )
                );
            }

            Yii::app()->user->setFlash(
                YFlashMessages::ERROR_MESSAGE, $message
            );
            $this->redirect($redirect);
        }
    }

    /**
     * Отрисовка комментария:
     *
     * @param class $comment - комментарий
     *
     * @return string html отрисованного комментария
     **/
    private function _renderComment($comment = null)
    {
        if ($comment === null)
            return '';

        ob_start();

        $comment->refresh();

        $this->widget(
            'application.modules.comment.widgets.CommentsListWidget', array(
                'comment' => $comment
            )
        );

        return ob_get_clean();
    }
}