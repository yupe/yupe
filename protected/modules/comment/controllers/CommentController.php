<?php
/**
 * Comment controller class:
 *
 * @category YupeControllers
 * @package  YupeCMS
 * @author   AKulikov <tuxuls@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1 (dev)
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
                'class'     => 'CCaptchaAction',
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
        //sleep(5);
        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest)
            return $this->_ajaxRequest();

        echo '<pre>';
        print_r($_POST);
        die('</pre>');

        if (Yii::app()->request->isPostRequest && Yii::app()->request->getPost('Comment')!== null) {
            $redirect = Yii::app()->request->getPost('redirectTo', Yii::app()->user->returnUrl);

            $comment = new Comment;
            $comment->setAttributes(
                Yii::app()->request->getPost('Comment')
            );

            $module = Yii::app()->getModule('comment');
            $comment->status = $module->defaultCommentStatus;

            if (Yii::app()->user->isAuthenticated()) {
                $comment->setAttributes(
                    array(
                        'user_id' => Yii::app()->user->id,
                        'name'    => Yii::app()->user->getState('nick_name'),
                        'email'   => Yii::app()->user->getState('email'),
                    )
                );

                if ($module->autoApprove)
                    $comment->status = Comment::STATUS_APPROVED;
            }

            if ($comment->save()) {
                // сбросить кэш
                Yii::app()->cache->delete("Comment{$comment->model}{$comment->model_id}");

                // если нужно уведомить администратора - уведомляем =)
                if ($module->notify && ($notifier = new Notifier()) !== false) {
                    $comment->onNewComment = array($notifier, 'newComment');
                    $comment->newComment($comment);
                }

                if (Yii::app()->request->isAjaxRequest)
                    Yii::app()->ajax->success(Yii::t('CommentModule.comment', 'Комментарий добавлен!'));

                $message = $comment->status !== Comment::STATUS_APPROVED
                    ? Yii::t('CommentModule.comment', 'Спасибо, Ваша запись добавлена и ожидает проверки!')
                    : Yii::t('CommentModule.comment', 'Спасибо, Ваша запись добавлена!');

                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    $message
                );
                $this->redirect($redirect);
            } else {
                if (Yii::app()->request->isAjaxRequest)
                    Yii::app()->ajax->failure(Yii::t('CommentModule.comment', 'Запись не добавлена!'));

                Yii::app()->user->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    Yii::t('CommentModule.comment', 'Запись не добавлена! Заполните форму корректно!')
                );
                $this->redirect($redirect);
            }
        }
        throw new CHttpException(404, Yii::t('CommentModule.comment', 'Страница не найдена!'));
    }

    /**
     * Ajax-обработчик добавления комментариев:
     *
     * @return void
     **/
    private function _ajaxRequest()
    {
        $comment = new Comment;
        $comment->setAttributes(
            Yii::app()->request->getPost('Comment')
        );

        $module = Yii::app()->getModule('comment');
        $comment->status = $module->defaultCommentStatus;

        if (Yii::app()->user->isAuthenticated()) {
            $comment->setAttributes(
                array(
                    'user_id' => Yii::app()->user->id,
                    'name'    => Yii::app()->user->getState('nick_name'),
                    'email'   => Yii::app()->user->getState('email'),
                )
            );

            if ($module->autoApprove)
                $comment->status = Comment::STATUS_APPROVED;
        }

        if ($comment->save()) {
            $result = true;
            // сбросить кэш
            Yii::app()->cache->delete("Comment{$comment->model}{$comment->model_id}");

            // если нужно уведомить администратора - уведомляем =)
            if ($module->notify && ($notifier = new Notifier()) !== false) {
                $comment->onNewComment = array($notifier, 'newComment');
                $comment->newComment($comment);
            }

            $message = $comment->status !== Comment::STATUS_APPROVED
                ? Yii::t('CommentModule.comment', 'Спасибо, Ваша запись добавлена и ожидает проверки!')
                : Yii::t('CommentModule.comment', 'Спасибо, Ваша запись добавлена!');

        } else
            $message = Yii::t('CommentModule.comment', 'Запись не добавлена! Заполните форму корректно!');

        $commentContent = $comment->status !== Comment::STATUS_APPROVED
            ? ''
            : $this->renderComment($comment);

        isset($result) && $result
            ? Yii::app()->ajax->success(
                array(
                    'message'        => $message,
                    'comment'        => array(
                        'parent_id'  => $comment->parent_id
                    ),
                    'commentContent' => $commentContent
                )
            )
            : Yii::app()->ajax->failure(
                array(
                    'message'        => $message
                )
            );
    }

    /**
     * Отрисовка комментария:
     *
     * @param class $comment - комментарий
     *
     * @return string html отрисованного комментария
     **/
    public function renderComment($comment = null)
    {
        if ($comment === null)
            return '';

        ob_start();

        $comment->refresh();

        $this->widget(
            'application.modules.comment.widgets.CommentsListWidget', array(
                'fromController' => false,
                'comment' => $comment
            )
        );

        return ob_get_clean();
    }
}