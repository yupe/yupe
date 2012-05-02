<?php
class CommentController extends YFrontController
{
    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            )
        );
    }

    public function actionAdd()
    {
        if (Yii::app()->request->isPostRequest && !empty($_POST['Comment']))
        {
            $redirect = isset($_POST['redirectTo'])
                ? $_POST['redirectTo']
                : Yii::app()->user->returnUrl;

            $comment = new Comment;

            $comment->setAttributes($_POST['Comment']);
            
            $module = Yii::app()->getModule('comment');
            $comment->status = $module->defaultCommentStatus;

            if (Yii::app()->user->isAuthenticated())
            {
                $comment->setAttributes(array(
                    'user_id' => Yii::app()->user->getId(),
                    'name' => Yii::app()->user->getState('nick_name'),
                    'email' => Yii::app()->user->getState('email'),
                ));

                if($module->autoApprove)
                    $comment->status = Comment::STATUS_APPROVED;
            }

            if ($comment->save())
            {
                // сбросить кэш
                Yii::app()->cache->delete("Comment{$comment->model}{$comment->model_id}");

                // если нужно уведомить администратора - уведомляем =)
                if($module->notify && $module->email)
                {
                    $body = $this->renderPartial('commentnotifyemail', array('model'=>$comment), true);

                    Yii::app()->mail->send(
                        Yii::app()->getModule('yupe')->email,
                        $module->email,
                        Yii::t('comment', 'Добавлен новый комментарий на сайте "{app}"!',
                        array('{app}'=>Yii::app()->name)
                    ), $body);
                }

                if (Yii::app()->request->isAjaxRequest)
                    Yii::app()->ajax->success(Yii::t('comment', 'Комментарий добавлен!'));

                $message = $comment->status !== Comment::STATUS_APPROVED
                    ? Yii::t('comment', 'Спасибо, Ваш комментарий добавлен и ожидает проверки!')
                    : Yii::t('comment', 'Спасибо, Ваш комментарий добавлен!');

                Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, $message);

                $this->redirect($redirect);
            }
            else
            {
                if (Yii::app()->request->isAjaxRequest)
                    Yii::app()->ajax->failure(Yii::t('comment', 'Комментарий не добавлен!'));

                Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE, Yii::t('comment', 'Комментарий не добавлен! Заполните форму корректно!'));

                $this->redirect($redirect);
            }
        }

        throw new CHttpException(404, Yii::t('comment', 'Страница не найдена!'));
    }
}